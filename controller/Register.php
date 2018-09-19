<?php
namespace controller;

use view;

class Register {
    private $registerView;

    public function __construct() {
        $this->registerView = new view\RegisterView();
    }
    public function checkInputErrors() {
        return 'Username has too few characters, at least 3 characters.';
    }
}
