<?php
namespace controller;

use view;

class RouteController {
    private $loginView;
    private $dateTimeView;
    private $layoutView;
    private $userName;
    private $password;

    /**
     * Constructor make an instance of every view
     */
    public function __construct() {
        $this->loginView = new view\LoginView();
        $this->dateTimeView = new view\DateTimeView();
        $this->layoutView = new view\LayoutView();

        if (isset($_POST['LoginView::UserName']) && !empty($_POST['LoginView::UserName'])) {
            $this->userName = $_POST['LoginView::UserName'];
        }

        if (isset($_POST['LoginView::Password']) && !empty($_POST['LoginView::Password'])) {
            $this->password = $_POST['LoginView::Password'];
        }
    }

    /**
     * Route depending on what to do.
     *
     * @return void
     */
    public function route() {
        if ($this->loginAttempt()) {
            if ($this->userName == 'Admin' && $this->password == 'test') {
                $this->loginView->msg('Welcome');
                $this->layoutView->render(true, $this->loginView, $this->dateTimeView);
            } else {
                $this->loginView->msg('Wrong name or password');
                $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
            }
        } else {
            $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        }
    }

    /**
     * Returns true if user is trying to login
     *
     * @return boolean
     */
    private function loginAttempt() {
        return $_SERVER['REQUEST_METHOD'] == 'POST' &&
        $this->userName && $this->password;
    }
}
