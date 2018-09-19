<?php
namespace controller;

use model;
use view;

class MainController {
    private $view;
    private $register;
    private $dtv;
    private $lv;

    private $session;
    private $server;

    private $login;

    /**
     * Constructor
     */
    public function __construct() {
        $this->view = new view\LoginView();
        $this->register = new view\RegisterView();
        $this->dtv = new view\DateTimeView();
        $this->lv = new view\LayoutView();

        $this->session = new model\Session();
        $this->server = new model\Server();

        $this->login = new Login();
    }

    public function returnHTML(): string {
        $msg = '';
        $login = $this->login->isLoggedIn();

        if ($this->tryingToRegister()) {
            return $this->lv->render(false, $this->register, $this->dtv);
        }

        if ($this->server->isRepost()) {
            echo "This is a repost!";
            $_POST = array();
        } else {
            if ($this->tryingToLogout()) {
                $login = false;
                $this->login->logout();
                $this->view->message('Bye bye!');
                return $this->lv->render($login, $this->view, $this->dtv);
            }

            if ($this->tryingToLogin()) {
                if ($this->session->isRepost()) {
                    echo 'REPOST!!';
                }
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
        return $this->view->isPost() && $this->view->getUserName() && $this->view->getPassword();
    }

    private function tryingToLogout(): bool {
        return $this->view->getLogout();
    }
}
