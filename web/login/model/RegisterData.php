<?php

namespace model;

class RegisterData {
    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($username, $password, $passwordRepeat) {
        if (!$username && !$password && !$passwordRepeat) {
            throw new \ShortUserNameAndPassword();
        }

        if ($password != $passwordRepeat) {
            throw new \PasswordDontMatch();
        }

        if (strlen($password) < 6) {
            throw new \ShortPassword();
        }

        if (strlen($username) < 3) {
            throw new \ShortUserName();
        }

        if ($username != str_replace(array("<", ">"), "", $username)) {
            throw new \InvalidChars();
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
