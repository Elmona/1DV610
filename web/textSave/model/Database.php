<?php
namespace textSaveModel;

class Database {
    private $secrets;
    private $mysqli;

    public function __construct() {
        $this->secrets = new \Config();
        $this->mysqli = new \mysqli($this->secrets->host,
            $this->secrets->user, $this->secrets->password,
            $this->secrets->database, $this->secrets->port);

        $this->mysqli->query("CREATE TABLE IF NOT EXISTS `text`
            ( `id` INT AUTO_INCREMENT PRIMARY KEY,
            `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `name` VARCHAR(100) NOT NULL,
            `text` TEXT);");
    }

    public function getText(String $username) {
        $stmt = $this->mysqli->
            prepare("SELECT id, text, timestamp FROM `text` WHERE name=?");

        $stmt->bind_param("s", $username);

        $stmt->execute();
        $stmt->bind_result($id, $text, $date);

        $returnArr = array();
        while ($stmt->fetch()) {
            array_push($returnArr, new Post($id, $text, $date));
        }

        return $returnArr;
    }

    public function saveText(String $username, object $post): bool {
        if (!$this->checkIfUserOwnsPost($username, $post->getId())) {
            return false;
        }

        $stmt = $this->mysqli->
            prepare("REPLACE INTO `text` (id, name, text) VALUES (?, ?, ?)");

        $id = $post->getId();
        $text = $post->getText();
        $name = $username;

        $stmt->bind_param("sss", $id, $name, $text);
        $stmt->execute();

        return true;
    }

    public function addNewPost(String $username): void {
        $stmt = $this->mysqli->
            prepare("INSERT INTO `text` (name) VALUES (?)");

        $username = $username;

        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    public function deletePost(String $username, $post): bool {
        if (!$this->checkIfUserOwnsPost($username, $post->getId())) {
            return false;
        }

        $stmt = $this->mysqli->
            prepare("DELETE FROM `text` WHERE id=?");

        $id = $post->getId();

        $stmt->bind_param("s", $id);
        $stmt->execute();

        return true;
    }

    private function checkIfUserOwnsPost(String $username, $id): bool {
        $stmt = $this->mysqli->
            prepare("SELECT name FROM `text` WHERE id=?");

        $stmt->bind_param("s", $id);
        $stmt->bind_result($usernameFromDB);

        $stmt->execute();
        $stmt->fetch();

        return $username == $usernameFromDB;
    }
}
