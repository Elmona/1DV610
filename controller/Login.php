<?php
namespace controller;

class Login {
    public function isLoggedIn(): bool {
        return isset($_SESSION['login']) && $_SESSION['login'] == 'true';
    }

    public function saveLogin(): void {
        $_SESSION['login'] = true;
    }

}
