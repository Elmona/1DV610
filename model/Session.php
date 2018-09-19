<?php
namespace modell;

class Session {
    private static $key = 'key';

    public function getKey() {
        $randomNumber = $this->generateRandomNumber();
        $_SESSION[self::$key] = $randomNumber;
        return $randomNumber;
    }
    public function getName() {
        return self::$key;
    }

    private function generateRandomNumber() {
        return mt_rand(1, 1000000);
    }

    public function isRepost() {
        // echo md5($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'] . print_r($_POST, true));
        return isset($_POST[self::$key]) && $_POST[self::$key] != $_SESSION[self::$key];
    }
}
