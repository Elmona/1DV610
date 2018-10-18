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
            (`name` VARCHAR(100) NOT NULL,
            `text` TEXT, PRIMARY KEY (name));");
    }

    public function getText(String $username): string {
        $stmt = $this->mysqli->
            prepare("SELECT text FROM `text` WHERE name=?");

        $stmt->bind_param("s", $username);
        $stmt->bind_result($data);

        $stmt->execute();
        $stmt->fetch();

        return strlen($data) > 0 ? $data : '';
    }

    public function saveText(String $username, String $data): void {
        $stmt = $this->mysqli->
            prepare("REPLACE INTO `text` (name, text) VALUES (?, ?)");

        $stmt->bind_param("ss", $username, $data);
        $stmt->execute();
    }
}
