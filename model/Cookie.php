<?php
namespace model;

class Cookie {
    public function setCookie($value) {
        // Cookie is valid in 1 hour.
        setcookie('login', $value, time() + 3600);
    }

    public function destroyCookie() {

    }
}
