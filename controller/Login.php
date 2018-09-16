<?php
namespace controller;

class Login {
    public function isLoggedIn() {
        return isset($_SESSION['login']) && $_SESSION['login'] == 'true';
    }

    public function saveLogin() {
        $_SESSION['login'] = true;
        // $this->cookie->setCookie('login');
    }
}
