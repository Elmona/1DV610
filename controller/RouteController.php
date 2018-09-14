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
        $login = false;

        if (isset($_POST['LoginView::Logout'])) {
            $this->loginView->msg('Bye bye!');
            session_destroy();
        }
        if (isset($_SESSION['login']) && $_SESSION['login'] == 'true') {
            $login = true;
        } else {
            if ($this->loginAttempt()) {
                if ($this->testCredentials()) {
                    $_SESSION['login'] = 'true';
                    $login = true;
                    $this->loginView->msg('Welcome');
                } else {
                    $this->loginView->msg('Wrong name or password');
                }
            }
        }
        $this->layoutView->render($login, $this->loginView, $this->dateTimeView);
    }

    private function testCredentials() {
        return $this->userName == 'Admin' && $this->password == 'test';
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
