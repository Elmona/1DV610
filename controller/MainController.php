<?php
namespace controller;

class MainController {
    private $loginView;
    private $registerView;
    private $dateTimeView;
    private $layoutView;

    private $userLoginData;

    private $loginController;
    private $database;

    public function __construct() {
        $this->layoutView = new \view\LayoutView();
        $this->loginView = new \view\LoginView();
        $this->registerView = new \view\RegisterView();
        $this->dateTimeView = new \view\DateTimeView();

        $this->userLoginData = new \model\userLoginData($this->loginView->getUserName(),
            $this->loginView->getPassword(), false);

        $this->registerData = new \model\RegisterData($this->registerView->getUserName(),
            $this->registerView->getPassword(), $this->registerView->getPasswordRepeat());

        $this->database = new \model\Database();

        $this->loginController = new \controller\LoginController($this->loginView, $this->database);
    }

    public function returnHTML(): string {
        $isLoggedIn = $this->loginController->isLoggedInBySession();

        if ($this->loginView->tryingToRegister()) {
            if ($this->register()) {
                return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
            } else {
                return $this->layoutView->render(false, $this->registerView, $this->dateTimeView);
            }
        } else if ($this->loginController->cookiesExist() && !$isLoggedIn) {
            $isLoggedIn = $this->loginByCookie();
        } else if ($this->loginView->tryingToLogin() && !$isLoggedIn) {
            $isLoggedIn = $this->login();
        } else if ($this->loginView->tryingToLogout() && $isLoggedIn) {
            $isLoggedIn = $this->logout();
        }

        return $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
    }

    private function loginByCookie() {
        if ($this->loginController->isLoggedInByCookie()) {
            $this->loginView->message(\view\Messages::$welcomeBackWithCookie);
            return true;
        } else {
            $this->loginView->message(\view\Messages::$wrongInformationInCookies);
            return false;
        }
    }

    private function logout() {
        $this->loginController->logout();
        $this->loginView->message(\view\Messages::$byeBye);
        return false;
    }

    private function register() {
        if ($this->loginView->isPost()) {
            if ($this->registerData->inputErrors()) {
                $this->registerView->msg($this->registerData->inputErrorMessage());
            } else {
                if ($this->database->registerNewUser($this->registerData)) {
                    $this->loginView->message(\view\Messages::$registeredNewUser);
                    $this->loginView->registeredUsername($this->registerData->username());

                    return true;
                } else {
                    $this->registerView->msg(\view\Messages::$userExists);
                }
            }
        }
        return false;
    }

    private function login() {
        if ($this->userLoginData->inputErrors()) {
            $this->loginView->message($this->userLoginData->inputErrorMessage());
        } else {
            if ($this->database->testcredentials($this->userLoginData)) {
                $this->loginController->saveLogin($this->userLoginData);
                $this->loginView->message(\view\Messages::$welcome);
                return true;
            } else {
                $this->loginView->message(\view\Messages::$wrongNameOrPassword);
            }
        }
        return false;
    }
}
