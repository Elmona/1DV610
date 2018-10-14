<?php

namespace textSaveController;

class MainController {
    private $username;
    private $layoutView;
    private $database;

    public function __construct(string $username) {
        $this->username = $username;
        $this->layoutView = new \textSaveView\LayoutView();
        $this->database = new \textSaveModel\Database();
    }

    public function returnHTML() {
        if ($this->layoutView->isSaving()) {
            $this->database->
                saveText($this->username, $this->layoutView->getText());
            $this->layoutView->messageSaved();
        }

        $data = $this->database->getText($this->username);
        $this->layoutView->setData($data);

        return $this->layoutView->returnHTML();
    }
}
