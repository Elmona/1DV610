<?php
namespace controller;

use model;
use view;

class MainController {
    private $loginView;
    private $registerView;
    private $dateTimeView;
    private $layoutView;

    private $userLoginData;

    private $login;
    private $database;

    /**
     * Constructor
     */
    public function __construct() {
        $this->layoutView = new view\LayoutView();
        $this->loginView = new view\LoginView();
        $this->registerView = new view\RegisterView();
        $this->dateTimeView = new view\DateTimeView();

        $this->userLoginData = new model\userLoginData($this->loginView->getUserName(),
            $this->loginView->getPassword(), false);
        $this->registerData = new model\RegisterData($this->registerView->getUserName(),
            $this->registerView->getPassword(), $this->registerView->getPasswordRepeat());
        $this->database = new model\Database();

        $this->login = new Login();
    }

    public function returnHTML(): string {
        //var_dump($this->registerData);
        $msg = '';
        $login = $this->login->isLoggedIn();

        if ($this->tryingToLogout()) {
            $this->logout();
            $this->loginView->message($login ? 'Bye bye!' : '');

            return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        }

        if ($this->tryingToRegister()) {
            if ($this->isPost()) {
                if ($this->registerData->inputErrors()) {
                    $msg = $this->registerData->inputErrorMessage();
                } else {
                    if ($this->database->registerNewUser($this->registerData)) {
                        $this->loginView->message('Registered new user.');
                        return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
                    } else {
                        $msg = 'User exists, pick another username.';
                    }
                }
            }

            $this->registerView->msg($msg);
            return $this->layoutView->render(false, $this->registerView, $this->dateTimeView);
        }

        if ($this->isPost() && !$login) {
            if ($this->userLoginData->inputErrors()) {
                $msg = $this->userLoginData->inputErrorMessage();
            } else {
                if ($this->database->testCredentials($this->userLoginData)) {
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
