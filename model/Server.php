<?php
namespace model;

class Server {
    // Not used.
    public function isRepost() {
        return isset($_SERVER['HTTP_CACHE_CONTROL']) &&
            $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    }
}
