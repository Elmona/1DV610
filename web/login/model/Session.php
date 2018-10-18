<?php

namespace model;

class Session {
    private static $sessionName = 'sessionName';
    private static $sessionPassword = 'sessionPassword';
    private static $sessionFingerprint = 'fingerprint';
    private static $pepper;

    public function __construct() {
        self::$pepper = $_ENV['pepper'];
    }
    public function isLoggedInBySession($userAgent): bool {
        return isset($_SESSION[self::$sessionFingerprint])
        && $_SESSION[self::$sessionFingerprint] == md5($userAgent . self::$pepper);
    }

    public function saveSessionName($name): void {
        $_SESSION[self::$sessionName] = $name;
    }

    public function saveSessionPassword($name): void {
        $_SESSION[self::$sessionPassword] = $name;
    }

    public function saveSessionFingerprint($userAgent): void {
        $_SESSION[self::$sessionFingerprint] = md5($userAgent . self::$pepper);
    }

    public function getSessionName(): string {
        return $_SESSION[self::$sessionName];
    }

    public function destroySession(): void {
        session_destroy();
    }
}
