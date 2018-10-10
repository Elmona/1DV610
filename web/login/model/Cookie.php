<?php
namespace model;

class Cookie {
    public function setCookie($name, $value) {
        \setcookie($name, $value, time() + 3600);
    }

    public function removeCookie($name) {
        \setcookie($name, null, time() - 3600);
    }
}
