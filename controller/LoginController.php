<?php
namespace Controller;

use Cookie;
use Model;

class LoginController {
    private $cookie;
    private $database;

    private static $cookieName;
    private static $cookiePassword;

    private static $sessionName = 'sessionName';
    private static $sessionPassword = 'sessionPassword';
    private static $sessionFingerprint = 'fingerprint';
    private static $pepper = 'OzCJcRCZaYwNIHbmjhFf';

    public function __construct(\view\LoginView $loginView, \model\Database $database) {
        $this->cookie = new \model\Cookie();
        $this->database = new \model\Database();

        self::$cookieName = $loginView->getCookieName();
        self::$cookiePassword = $loginView->getCookiePassword();
    }

    public function cookiesExist(): bool {
        return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
    }

    public function isLoggedInByCookie(): bool {
        return $this->database->
            cookieAndUserAgentMatchDB($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword],
            $this->getUserAgent());
    }

    public function isLoggedInBySession(): bool {
        return isset($_SESSION[self::$sessionFingerprint])
        && $_SESSION[self::$sessionFingerprint] == md5($_SERVER['HTTP_USER_AGENT'] . self::$pepper);

    }

    public function saveLogin($userLoginData): void {
        $randomString = $this->generateRandomString();
        $userAgent = $this->getUserAgent();

        $_SESSION[self::$sessionName] = $userLoginData->username();
        $_SESSION[self::$sessionPassword] = $userLoginData->password();
        $_SESSION[self::$sessionFingerprint] = md5($_SERVER['HTTP_USER_AGENT'] . self::$pepper);

        $this->cookie->setcookie(self::$cookieName, $userLoginData->username());
        $this->cookie->setcookie(self::$cookiePassword, $randomString);

        $this->database->
            updateCookieAndUserAgent($userLoginData->username(),
            $randomString, $userAgent);
    }

    public function logout(): void {
        $this->cookie->removeCookie(self::$cookieName);
        $this->cookie->removeCookie(self::$cookiePassword);

        session_destroy();
    }

    // TODO: Refactor this later to a safer version.
    private function generateRandomString() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(md5(time()), 1);
    }

    private function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

}
