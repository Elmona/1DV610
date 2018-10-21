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

    public function returnHTML(): string {
        if ($this->layoutView->addingNewPost()) {
            $this->database->
                addNewPost($this->username);
            $this->layoutView->messageAddNewPost();
        }

        if ($this->layoutView->isSaving()) {
            $post = $this->layoutView->getPost();

            if ($this->database->saveText($this->username, $post)) {
                $this->layoutView->messageSaved();
            } else {
                $this->layoutView->messageStopItHacker();
            }

        }

        if ($this->layoutView->isDeleting()) {
            $post = $this->layoutView->getPost();

            if ($this->database->deletePost($this->username, $post)) {
                $this->layoutView->messageDeletedPost();
            } else {
                $this->layoutView->messageStopItHacker();
            }
        }

        $data = $this->database->getText($this->username);
        $this->layoutView->setData($data);

        return $this->layoutView->returnHTML();
    }
}
