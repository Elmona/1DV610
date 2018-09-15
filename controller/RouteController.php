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

    private $post;
    private $loggedin;

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

        $this->post = $_SERVER['REQUEST_METHOD'] == 'POST';
        $this->loggedin = isset($_SESSION['login']) && $_SESSION['login'] == 'true';
    }

    /**
     * Check if global variable is set and return it.
     *
     * @param [string] $name
     * @return string
     */
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
        $msg = '';
        $login = false;

        if ($this->loggedin) {
            $login = true;
        }

        if ($this->post && $this->userName && $this->password) {
            if ($this->testCredentials()) {
                $_SESSION['login'] = true;
                $login = true;
                $msg = 'Welcome';
            } else {
                $msg = 'Wrong name or password';
            }
        } else if ($this->post && $this->userName && !$this->password) {
            $msg = 'Password is missing';
        } else if ($this->post) {
            $msg = 'Username is missing';
        }

        if ($this->logout) {
            $msg = 'Bye bye!';
            session_destroy();
        }

        $this->loginView->msg($msg);
        $this->layoutView->render($login, $this->loginView, $this->dateTimeView);
    }

    private function testCredentials() {
        // TODO: Ask database.
        return $this->userName == 'Admin' && $this->password == 'test';
    }
}
