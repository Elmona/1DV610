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
        || $this->password != $this->passwordRepeat;
    }

    public function inputErrorMessage(): string {
        if (strlen($this->username) < 3) {
            return 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters';
        } else if (strlen($this->password) < 6) {
            return 'Password has too few characters, at least 6 characters.';
        } else if ($this->password != $this->passwordRepeat) {
            return 'Passwords do not match.';
        } else {
            throw new \Exception('Call inputErrors() before this function.');
        }
    }
}
