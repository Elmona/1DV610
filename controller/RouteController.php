<?php
namespace controller;

use view;

class RouteController {
    private $loginView;
    private $dateTimeView;
    private $layoutView;

    private $userName;
    private $password;
    private $logout;

    /**
     * Constructor make an instance of every view
     */
    public function __construct() {
        $this->loginView = new view\LoginView();
        $this->dateTimeView = new view\DateTimeView();
        $this->layoutView = new view\LayoutView();

        $this->userName = $this->saveIfExist('LoginView::UserName');
        $this->password = $this->saveIfExist('LoginView::Password');
        $this->logout = $this->saveIfExist('LoginView::Logout');
    }

    private function saveIfExist($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return $_POST[$name];
        } else {
            return null;
        }
    }

    /**
     * Main Router.
     *
     * @return void
     */
    public function route() {
        $login = false;
        $msg = '';
        if (isset($_POST['LoginView::Logout'])) {
            $msg = 'Bye bye!';
            session_destroy();
        }
        if (isset($_SESSION['login']) && $_SESSION['login'] == 'true') {
            $login = true;
        } else {
            if ($this->loginAttempt()) {
                if ($this->testCredentials()) {
                    $_SESSION['login'] = 'true';
                    $login = true;
                    $msg = 'Welcome';
                } else {
                    $msg = 'Wrong name or password';
                }
            }
        }
        $this->loginView->msg($msg);
        $this->layoutView->render($login, $this->loginView, $this->dateTimeView);
    }

    private function testCredentials() {
        // TODO: Ask database.
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
