<?php
namespace view;

class FormView {
    private $session;

    public function __construct() {
        $this->session = new \modell\Session();
    }

    protected function generateHiddenField() {
        return '<input type="hidden" name="' . $this->session->getName() . '" value="' . $this->session->getKey() . '" />';
    }
}
