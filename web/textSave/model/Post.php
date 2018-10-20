<?php

namespace textSaveModel;

class Post {
    private $id;
    private $text;
    private $date;

    public function __construct($id, $text, $date) {
        $this->id = $id;
        $this->text = $text;
        $this->date = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getDate() {
        return $this->date;
    }
}
