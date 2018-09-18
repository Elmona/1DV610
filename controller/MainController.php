<?php
namespace controller;

use view;

class MainController {
    private $view;
    private $register;
    private $dtv;
    private $lv;

    private $login;

    /**
     * Constructor
     */
    public function __construct() {
        $this->view = new view\LoginView();
        $this->register = new view\RegisterView();
        $this->dtv = new view\DateTimeView();
        $this->lv = new view\LayoutView();

        $this->login = new Login();
    }

    public function returnHTML(): string {
        $msg = '';

        if ($this->tryingToRegister()) {
            return $this->lv->render(false, $this->register, $this->dtv);
        }

        $login = $this->login->isLoggedIn();

        if ($this->tryingToLogout() && $login) {
            $login = false;
            $this->login->logout();
            $this->view->message('Bye bye!');
            return $this->lv->render($login, $this->view, $this->dtv);
        }

        if ($this->tryingToLogin() && !$login) {
            if ($this->login->testcredentials($this->view->getUserName(), $this->view->getPassword())) {
                $this->login->saveLogin();
                $login = true;
                $msg = 'Welcome';
            } else {
                $msg = 'Wrong name or password';
            }
        } else if ($this->tryingToLoginWithoutName()
            || $this->tryingToLoginWithoutNameAndPassword()) {
            $msg = 'Username is missing';
        } else if ($this->tryingToLoginWithoutPassword()) {
            $msg = 'Password is missing';
        }

        $this->view->message($msg);
        return $this->lv->render($login, $this->view, $this->dtv);
    }

    private function tryingToRegister(): bool {
        return $this->view->register();
    }

    private function tryingToLoginWithoutNameAndPassword(): bool {
        return $this->view->isPost() && !$this->view->getUserName() && !$this->view->getPassword();
    }

    private function tryingToLoginWithoutName(): bool {
        return $this->view->isPost() && !$this->view->getUserName() && $this->view->getPassword();
    }

    private function tryingToLoginWithoutPassword(): bool {
        return $this->view->isPost() && $this->view->getUserName() && !$this->view->getPassword();
    }

    private function tryingToLogin(): bool {
        return $this->view->isPost() && $this->view->getUserName() && $this->view->getPassword() && $this->view->submit();
    }

    private function tryingToLogout(): bool {
        return $this->view->getLogout();
    }
}
