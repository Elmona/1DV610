<?php
namespace controller;

use view;

class MainController {
    private $view;
    private $dtv;
    private $lv;

    private $login;

    /**
     * Constructor
     */
    public function __construct() {
        $this->view = new view\LoginView();
        $this->dtv = new view\DateTimeView();
        $this->lv = new view\LayoutView();

        $this->login = new Login();
    }

    public function returnHTML(): string {
        $msg = '';
        $login = $this->login->isLoggedIn();

        if ($this->tryingToLogout() && $login) {
            $msg = 'Bye bye!';
            $login = false;
            $this->login->logout();
        }

        if ($this->tryingToLogin()) {
            if ($this->testcredentials()) {
                $this->login->savelogin();
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

        $this->view->message($msg);
        return $this->lv->render($login, $this->view, $this->dtv);
    }

    private function tryingToLoginWithoutPassword(): bool {
        return $this->view->isPost() && $this->view->getUserName() && !$this->view->getPassword();
    }

    private function tryingToLoginWithoutName(): bool {
        return $this->view->isPost() && !$this->view->getUserName() && $this->view->getPassword();
    }

    private function tryingToLogout(): bool {
        return $this->view->getLogout();
    }

    private function tryingToLogin(): bool {
        return $this->view->isPost() && $this->view->getUserName() && $this->view->getPassword();
    }

    private function testcredentials(): bool {
        return $this->view->getUserName() == 'Admin' && $this->view->getPassword() == 'test';
    }
}
