<?php

namespace model;

class UserLoginData {
    private $userName;
    private $password;
    private $keepLogin;

    public function __construct($userName, $password, $keepLogin) {
        $this->userName = $userName;
        $this->password = $password;
        $this->keepLogin = $keepLogin;
    }

    public function username(): string {
        return $this->userName;
    }

    public function password(): string {
        return $this->password;
    }

    public function inputErrors(): bool {
        return !$this->password || !$this->userName;
    }

    public function inputErrorMessage(): string {
        if (!$this->userName) {
            return 'Username is missing';
        } else if (!$this->password) {
            return 'Password is missing';
        } else {
            throw new \Exception('Call inputErrors() before this function.');
        }
    }
}
