<?php
namespace Controller;

use Cookie;
use Model;

class LoginController {
    private $cookie;
    private $session;
    private $database;

    private static $cookieName;
    private static $cookiePassword;

    private static $userAgent;

    public function __construct(\view\LoginView $loginView, \model\Database $database, \model\Session $session) {
        $this->cookie = new \model\Cookie();
        $this->session = $session;
        $this->database = $database;

        self::$cookieName = $loginView->getCookieName();
        self::$cookiePassword = $loginView->getCookiePassword();
        self::$userAgent = $loginView->getUserAgent();
    }

    public function cookiesExist(): bool {
        return $this->cookie->cookieExist(self::$cookiePassword)
        && $this->cookie->cookieExist(self::$cookieName);
    }

    public function isLoggedInByCookie(): bool {
        return $this->database->
            cookieAndUserAgentMatchDB($this->cookie->getCookie(self::$cookieName)
            , $this->cookie->getCookie(self::$cookiePassword), self::$userAgent);
    }

    public function saveLoginByCookie(): void {
        $randomString = $this->generateRandomString();

        $this->session->saveSessionName($this->cookie->getCookie(self::$cookieName));
        $this->session->saveSessionFingerprint(self::$userAgent);
        $this->cookie->setcookie(self::$cookiePassword, $randomString);

        $this->database->
            updateCookieAndUserAgent($this->cookie->getCookie(self::$cookieName),
            $randomString, self::$userAgent);
    }

    public function isLoggedInBySession(): bool {
        return $this->session->isLoggedInBySession(self::$userAgent);
    }

    public function saveLogin($userLoginData): void {
        $randomString = $this->generateRandomString();

        $this->session->saveSessionName($userLoginData->username());
        $this->session->saveSessionFingerprint(self::$userAgent);

        $this->cookie->setcookie(self::$cookieName, $userLoginData->username());
        $this->cookie->setcookie(self::$cookiePassword, $randomString);

        $this->database->
            updateCookieAndUserAgent($userLoginData->username(),
            $randomString, self::$userAgent);
    }

    public function logout(): void {
        $this->cookie->removeCookie(self::$cookieName);
        $this->cookie->removeCookie(self::$cookiePassword);

        $this->session->destroySession();
    }

    private function generateRandomString() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(md5(time()), 1);
    }
}
