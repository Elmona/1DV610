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

        $this->createCredentialsTableIfNotExists();
    }

    private function createCredentialsTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS `credentials`
        ( `id` INT AUTO_INCREMENT PRIMARY KEY,
         `name` VARCHAR(100) NOT NULL , `password` VARCHAR(100) NOT NULL,
         `cookie` VARCHAR(255) );";
        return $this->mysqli->query($sql);
    }

    public function testCredentials(UserLoginData $user) {
        $username = $user->username();
        $stmt = $this->mysqli->prepare("SELECT (password) FROM `credentials` WHERE name=?");
        $stmt->bind_param("s", $username);
        $stmt->bind_result($hashedPassword);
        $stmt->execute();

        if ($stmt->fetch() && password_verify($user->password(), $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function registerNewUser(RegisterData $user) {
        if ($this->checkIfUserAlreadyExist($user->username())) {
            return false;
        } else {
            $stmt = $this->mysqli->prepare("INSERT INTO `credentials` (name, password) VALUES (?, ?)");

            $bcryptPassword = password_hash($user->password(), PASSWORD_BCRYPT, ["cost" => 10]);
            $username = $user->username();

            $stmt->bind_param("ss", $username, $bcryptPassword);
            $stmt->execute();

            return true;
        }
    }

    private function checkIfUserAlreadyExist($username) {
        $stmt = $this->mysqli->prepare("SELECT (name) FROM `credentials` WHERE name=?");
        $stmt->bind_param("s", $username);

        if (!$stmt->execute()) {
            throw new Exception('Error executing MySQL query: ' . $stmt->error);
        }

        return $stmt->fetch();
    }
}
