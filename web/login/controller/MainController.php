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

    private $loginController;
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

        $this->loginController = new \controller\LoginController($this->loginView, $this->database);
    }

    public function returnHTML(): string {
        // echo "<pre>" . var_dump(base64_encode(random_bytes(100)));substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        // die;

        $msg = '';
        $login = $this->loginController->isLoggedInBySession();

        if ($this->loginController->cookiesExist() && !$login) {
            if ($this->loginController->isLoggedInByCookie()) {
                $this->loginView->message('Welcome back with cookie');
                return $this->layoutView->render(true, $this->loginView, $this->dateTimeView);
            } else {
                $this->loginView->message('Wrong information in cookies');
                return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
            }
        }

        if ($this->tryingToLogout()) {
            $this->loginController->logout();
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
                        $this->loginView->registeredUsername($this->registerData->username());

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
                if ($this->database->testcredentials($this->userLoginData)) {
                    $login = true;
                    $this->loginController->saveLogin($this->userLoginData);
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
}
