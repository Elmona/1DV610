<?php

namespace model;

class RegisterData {
    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($username, $password, $passwordRepeat) {
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

    public function inputErrors(): bool {
        return strlen($this->username) < 3 || strlen($this->password) < 6
        || $this->password != $this->passwordRepeat || $this->username != strip_tags($this->username);
    }

    public function inputErrorMessage(): string {
        $msg = '';

        if ($this->password != $this->passwordRepeat) {
            $msg = 'Passwords do not match.';
        }

        if (strlen($this->password) < 6) {
            $msg = 'Password has too few characters, at least 6 characters.';
        }

        if (strlen($this->username) < 3) {
            $msg = 'Username has too few characters, at least 3 characters.';
        }

        if (!$this->username && !$this->password && !$this->passwordRepeat) {
            $msg = 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.';
        }

        if ($this->username != strip_tags($this->username)) {
            $msg = 'Username contains invalid characters.';
        }

        return $msg;
    }
}
