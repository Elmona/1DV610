<?php
namespace modell;

class Server {
    public function isRepost() {
        return isset($_SERVER['HTTP_CACHE_CONTROL']) &&
            $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    }
}
