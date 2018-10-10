<?php

namespace model;

class RegisterData {
    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($username, $password, $passwordRepeat) {
        $msg = '';

        if ($password != $passwordRepeat) {
            $msg = 'Passwords do not match.';
        }

        if (strlen($password) < 6) {
            $msg = 'Password has too few characters, at least 6 characters.';
        }

        if (strlen($username) < 3) {
            $msg = 'Username has too few characters, at least 3 characters.';
        }

        if (!$username && !$password && !$passwordRepeat) {
            $msg = 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.';
        }

        if ($username != str_replace(array("<", ">"), "", $username)) {
            $msg = 'Username contains invalid characters.';
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
