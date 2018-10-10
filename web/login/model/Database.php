<?php
namespace model;

class Database {
    private $secrets;
    private $mysqli;

    public function __construct() {
        $this->secrets = new \Config();
        $this->mysqli = new \mysqli($this->secrets->host,
            $this->secrets->user, $this->secrets->password,
            $this->secrets->database, $this->secrets->port);

        $this->mysqli->query("CREATE TABLE IF NOT EXISTS `credentials`
            ( `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL , `password` VARCHAR(1000) NOT NULL,
            `cookie` VARCHAR(255), `userAgent` VARCHAR(100) );");
    }

    public function testCredentials(UserLoginData $user): bool {
        $username = $user->username();

        $stmt = $this->mysqli->
            prepare("SELECT name, password FROM `credentials` WHERE name=?");

        $stmt->bind_param("s", $username);
        $stmt->bind_result($userNameFromDB, $hashedPassword);
        $stmt->execute();
        $stmt->fetch();

        if ($userNameFromDB === $username
            && password_verify($user->password(), $hashedPassword)) {

            return true;

        } else {return false;}
    }

    public function registerNewUser(RegisterData $user): bool {
        if (!$this->checkIfUserNameAlreadyExist($user->username())) {
            $stmt = $this->mysqli->
                prepare("INSERT INTO `credentials` (name, password) VALUES (?, ?)");

            $bcryptPassword = password_hash($user->password()
                , PASSWORD_BCRYPT, ["cost" => 10]);

            $username = $user->username();

            $stmt->bind_param("ss", $username, $bcryptPassword);
            $stmt->execute();

            return true;
        } else {return false;}
    }

    private function checkIfUserNameAlreadyExist($username): bool {
        $stmt = $this->mysqli->
            prepare("SELECT name FROM `credentials` WHERE name=?");

        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->fetch() ? true : false;
    }

    public function updateCookieAndUserAgent($username, $randomString, $agent): void {
        $stmt = $this->mysqli->
            prepare("UPDATE `credentials` SET cookie=?, userAgent=? WHERE name=?");

        $stmt->bind_param("sss", $cookie, $userAgent, $name);

        $cookie = $randomString;
        $userAgent = $agent;
        $name = $username;

        $stmt->execute();
    }

    public function cookieAndUserAgentMatchDB($username, $cookie, $userAgent): bool {
        $stmt = $this->mysqli->
            prepare("SELECT cookie, userAgent FROM `credentials` WHERE name=?");

        $stmt->bind_param("s", $user);
        $stmt->bind_result($dbCookie, $dbUserAgent);

        $user = $username;

        $stmt->execute();
        $stmt->fetch();

        return $cookie == $dbCookie && $userAgent == $dbUserAgent;
    }
}
