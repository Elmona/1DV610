<?php
namespace controller;

class Login {
    public function isLoggedIn() {
        return isset($_SESSION['login']) && $_SESSION['login'] == 'true';
    }

    public static function saveLogin() {
        $_SESSION['login'] = true;
        // $this->cookie->setCookie('login');
    }

    public static function logout() {
        session_destroy();
    }
}
