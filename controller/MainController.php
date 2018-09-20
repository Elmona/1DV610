<?php
namespace controller;

use model;
use view;

class MainController {
    private $loginView;
    private $registerView;
    private $dateTimeView;
    private $layoutView;

    private $session;
    private $server;
    private $userLoginData;

    private $login;
    private $register;

    /**
     * Constructor
     */
    public function __construct() {
        $this->layoutView = new view\LayoutView();
        $this->loginView = new view\LoginView();
        $this->registerView = new view\RegisterView();
        $this->dateTimeView = new view\DateTimeView();

        $this->session = new model\Session();
        $this->server = new model\Server();
        $this->userLoginData = new model\userLoginData($this->loginView->getUserName(),
            $this->loginView->getPassword(), false);

        $this->login = new Login();
        $this->register = new Register();
    }

    public function returnHTML(): string {
        // var_dump($this->userLoginData->inputErrors());
        $msg = '';
        $login = $this->login->isLoggedIn();

        if ($this->tryingToLogout()) {
            $this->logout();
            $this->loginView->message($login ? 'Bye bye!' : '');

            return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        }

        if ($this->tryingToRegister()) {
            if ($this->isPost()) {
                $msg = $this->register->checkInputErrors();
            }

            $this->registerView->msg($msg);
            return $this->layoutView->render(false, $this->registerView, $this->dateTimeView);
        }

        if ($this->isPost() && !$login) {
            if ($this->userLoginData->inputErrors()) {
                $msg = $this->userLoginData->inputErrorMessage();
            } else {
                if ($this->login->testcredentials($this->userLoginData->username(), $this->userLoginData->password())) {
                    $login = true;
                    $this->login->saveLogin();
                    $msg = 'Welcome';
                } else {
                    $msg = 'Wrong name or password';
                }
            }
        }

        $this->loginView->message($msg);
        return $this->layoutView->render($login, $this->loginView, $this->dateTimeView);
    }

    private function tryingToRegister(): bool {
        return $this->loginView->register();
    }

    private function tryingToLogout(): bool {
        return $this->loginView->getLogout();
    }

    private function isPost() {
        return $this->loginView->isPost();
    }

    public function logout(): void {
        session_destroy();
    }
}
