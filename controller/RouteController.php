<?php
namespace controller;

use view;

class RouteController {
    private $loginView;
    private $dateTimeView;
    private $layoutView;

    /**
     * Constructor make an instance of every view
     */
    public function __construct() {
        $this->loginView = new view\LoginView();
        $this->dateTimeView = new view\DateTimeView();
        $this->layoutView = new view\LayoutView();
    }

    /**
     * Route depending on what to do.
     *
     * @return void
     */
    public function route() {
        if ($this->requestMethodIsPOST() && $this->userNameAndPasswordIsPosted()) {
            $this->layoutView->render(true, $this->loginView, $this->dateTimeView);
        } else {
            $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        }
    }

    private function requestMethodIsPOST(): bool {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    private function userNameAndPasswordIsPosted(): bool {
        return $_POST['LoginView::UserName']
            && $_POST['LoginView::Password'];
    }
}
