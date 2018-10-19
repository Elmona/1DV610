<?php

namespace model;

class UserLoginData {
    private $userName;
    private $password;
    private $keepLogin;

    public function __construct($userName, $password, $keepLogin) {
        if (!$userName) {
            throw new \UserNameMissing();
        }

        if (!$password) {
            throw new \PasswordMissing();
        }

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

    public function keeplogin(): bool {
        return $this->keepLogin ? true : false;
    }
}
