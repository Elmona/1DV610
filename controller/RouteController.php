<?php
namespace controller;

use model;
use view;

class RouteController {
    private $cookie;
    private $globals;

    private $loginView;
    private $dateTimeView;
    private $layoutView;

    private $userName;
    private $password;
    private $logout;

    private $isPost;
    private $loggedin;

    /**
     * Constructor
     */
    public function __construct() {
        $this->cookie = new model\Cookie();
        $this->globals = new model\Globals();

        $this->loginView = new view\LoginView();
        $this->dateTimeView = new view\DateTimeView();
        $this->layoutView = new view\LayoutView();

        $this->userName = $this->globals->getPost('LoginView::UserName');
        $this->password = $this->globals->getPost('LoginView::Password');
        $this->logout = $this->globals->getPost('LoginView::Logout');

        $this->isPost = $this->globals->isPost();
        $this->loggedin = isset($_SESSION['login']) && $_SESSION['login'] == 'true';
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
        } else {
            if ($this->isPost && $this->userName && $this->password) {
                if ($this->testCredentials()) {
                    $this->saveLogin();
                    $login = true;
                    $msg = 'Welcome';
                } else {
                    $msg = 'Wrong name or password';
                }
            } else if ($this->isPost && $this->userName && !$this->password) {
                $msg = 'Password is missing';
            } else if ($this->isPost && !$this->userName) {
                $msg = 'Username is missing';
            }
        }

        if ($this->logout && $this->loggedin) {
            $msg = 'Bye bye!';
            $login = false;
            session_destroy();
        }

        $this->loginView->msg($msg);
        $this->layoutView->render($login, $this->loginView, $this->dateTimeView);
    }

    private function testCredentials() {
        // TODO: Ask database.
        return $this->userName == 'Admin' && $this->password == 'test';
    }

    private function saveLogin() {
        $_SESSION['login'] = true;
        $this->cookie->setCookie('login');
    }
}
