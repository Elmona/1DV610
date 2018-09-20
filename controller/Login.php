<?php
namespace controller;

class Login {
    public function testcredentials($username, $password): bool {
        return $username == 'Admin' && $password == 'test';
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['login']) && $_SESSION['login'] == 'true';
    }

    public function saveLogin(): void {
        $_SESSION['login'] = true;
        // header('Location: /');
        // $this->cookie->setCookie('login');
    }

}
