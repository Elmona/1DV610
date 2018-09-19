<?php
namespace controller;

use model;
use view;

class MainController {
    private $view;
    private $registerView;
    private $dtv;
    private $lv;

    private $session;
    private $server;

    private $login;
    private $register;

    /**
     * Constructor
     */
    public function __construct() {
        $this->view = new view\LoginView();
        $this->registerView = new view\RegisterView();
        $this->dtv = new view\DateTimeView();
        $this->lv = new view\LayoutView();

        $this->session = new model\Session();
        $this->server = new model\Server();

        $this->login = new Login();
        $this->register = new Register();
    }

    public function returnHTML(): string {
        $msg = '';
        $login = $this->login->isLoggedIn();

        if ($this->tryingToLogout() && $login) {
            $this->login->logout();
            $this->view->message('Bye bye!');
            return $this->lv->render(false, $this->view, $this->dtv);
        } else if ($this->tryingToLogout() && !$login) {
            return $this->lv->render(false, $this->view, $this->dtv);
        }

        if ($this->tryingToRegister()) {
            if ($this->isPost()) {
                $msg = $this->register->checkInputErrors();
            }
            $this->registerView->msg($msg);
            return $this->lv->render(false, $this->registerView, $this->dtv);
        }

        if ($this->isPost() && !$login) {
            if ($this->tryingToLogin()) {
                if ($this->login->
                    testcredentials($this->view->getUserName(), $this->view->getPassword())) {
                    $this->login->saveLogin();
                    $login = true;
                    $msg = 'Welcome';
                } else {
                    $msg = 'Wrong name or password';
                }
            } else if ($this->tryingToLoginWithoutName()) {
                $msg = 'Username is missing';
            } else if ($this->tryingToLoginWithoutPassword()) {
                $msg = 'Password is missing';
            }
        }

        $this->view->message($msg);
        return $this->lv->render($login, $this->view, $this->dtv);
    }

    private function tryingToRegister(): bool {
        return $this->view->register();
    }

    private function tryingToLogout(): bool {
        return $this->view->getLogout();
    }

    private function isPost() {
        return $this->view->isPost();
    }

    // private function tryingToLoginWithoutNameAndPassword(): bool {
    //     return !$this->view->getUserName() && !$this->view->getPassword();
    // }

    private function tryingToLoginWithoutName(): bool {
        return !$this->view->getUserName();
    }

    private function tryingToLoginWithoutPassword(): bool {
        return $this->view->getUserName() && !$this->view->getPassword();
    }

    private function tryingToLogin(): bool {
        return $this->view->getUserName() && $this->view->getPassword();
    }
}
