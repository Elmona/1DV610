<?php

namespace model;

class UserLoginData {
    private static $userName;
    private static $password;
    private static $keepLogin;

    public function __construct($userName, $password, $keepLogin) {
        self::$userName = $userName;
        self::$password = $password;
        self::$keepLogin = $keepLogin;
    }

    public function username(): string {
        return self::$userName;
    }

    public function password(): string {
        return self::$password;
    }

    public function inputErrors(): bool {
        return !self::$password || !self::$userName;
    }

    public function inputErrorMessage(): string {
        if (!self::$userName) {
            return 'Username is missing';
        } else if (!self::$password) {
            return 'Password is missing';
        } else {
            throw new \Exception('Call inputErrors() before this function.');
        }
    }
}
