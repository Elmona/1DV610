<?php

namespace TextSave;

require_once 'controller/MainController.php';
require_once 'model/Database.php';
require_once 'model/Post.php';
require_once 'view/LayoutView.php';

class TextSave {
    private $mainController;

    public function __construct(string $username) {
        $this->mainController = new \textSaveController\MainController($username);
    }

    public function returnHTML() {
        return $this->mainController->returnHTML();
    }
}
