<?php
namespace model;

class Globals {
    /**
     * Check if global variable is set and return it.
     *
     * @param [string] $name
     * @return string
     */
    public function getPost($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return $_POST[$name];
        } else {
            return null;
        }
    }

    /**
     * Check if server REQUEST_METHOD is post
     *
     * @return boolean
     */
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
} 