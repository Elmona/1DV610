<?php
namespace model;

class Cookie {
    public function setCookie($name, $value): void {
        \setcookie($name, $value, time() + 3600);
    }

    public function removeCookie($name): void {
        \setcookie($name, null, time() - 3600);
    }

    public function cookieExist($name): bool {
        return isset($_COOKIE[$name]);
    }

    public function getCookie($name): string {
        return $_COOKIE[$name];
    }

    public function generateRandomString() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(md5(time()), 1);
    }
}
