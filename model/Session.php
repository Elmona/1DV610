<?php
namespace model;

class Session {
    // private static $key = 'key';

    // public function isRepost() {
    //     $RequestSignature = md5($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'] . print_r($_POST, true));

    //     if (isset($_SESSION['LastRequest']) && $_SESSION['LastRequest'] == $RequestSignature) {
    //         // echo 'This is a refresh.';
    //         return true;
    //     } else {
    //         // echo 'This is a new request.';
    //         $_SESSION['LastRequest'] = $RequestSignature;
    //         return false;
    //     }
    // }
    // public function getKey() {
    //     $randomNumber = $this->generateRandomNumber();
    //     $_SESSION[self::$key] = $randomNumber;
    //     return $randomNumber;
    // }

    // public function setKey() {
    //     $randomNumber = $this->generateRandomNumber();
    //     $_SESSION[self::$key] = $randomNumber;
    // }

    // public function getName() {
    //     return self::$key;
    // }

    // private function generateRandomNumber() {
    //     return mt_rand(1, 1000000);
    // }

    // public function isRepost() {
    //     return isset($_POST[self::$key]) && $_POST[self::$key] != $_SESSION[self::$key];
    // }
}
