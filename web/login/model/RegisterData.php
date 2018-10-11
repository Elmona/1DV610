<?php

namespace model;

class RegisterData {
    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($username, $password, $passwordRepeat) {
        $msg = '';

        if ($password != $passwordRepeat) {
            $msg = 'passwordDontMatch';
        }

        if (strlen($password) < 6) {
            $msg = 'shortPassword';
        }

        if (strlen($username) < 3) {
            $msg = 'shortUsername';
        }

        if (!$username && !$password && !$passwordRepeat) {
            $msg = 'shortUsernameAndPassword';
        }

        if ($username != str_replace(array("<", ">"), "", $username)) {
            $msg = 'invalidChars';
        }

        if (strlen($msg) > 0) {
            throw new \Exception($msg);
        }

        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function username(): string {
        return $this->username;
    }

    public function password(): string {
        return $this->password;
    }
}
