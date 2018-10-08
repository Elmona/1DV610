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
        $msg = '';

        if ($this->loginController->cookiesExist() && !$isLoggedIn) {
            if ($this->loginController->isLoggedInByCookie()) {
                $this->loginView->message(\view\Messages::$welcomeBackWithCookie);
                $isLoggedIn = true;
            } else {
                $this->loginView->message(\view\Messages::$wrongInformationInCookies);
                $isLoggedIn = false;
            }
        }

        if ($this->tryingToLogout()) {
            $this->loginController->logout();
            $this->loginView->message($isLoggedIn ? \view\Messages::$byeBye : '');
            return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        }

        if ($this->tryingToRegister()) {
            if ($this->isPost()) {
                if ($this->registerData->inputErrors()) {
                    $msg = $this->registerData->inputErrorMessage();
                } else {
                    if ($this->database->registerNewUser($this->registerData)) {
                        $this->loginView->message(\view\Messages::$registeredNewUser);
                        $this->loginView->registeredUsername($this->registerData->username());

                        return $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
                    } else {
                        $msg = \view\Messages::$userExists;
                    }
                }
            }

            $this->registerView->msg($msg);
            return $this->layoutView->render(false, $this->registerView, $this->dateTimeView);
        }

        if ($this->isPost() && !$isLoggedIn) {
            if ($this->userLoginData->inputErrors()) {
                $msg = $this->userLoginData->inputErrorMessage();
            } else {
                if ($this->database->testcredentials($this->userLoginData)) {
                    $isLoggedIn = true;
                    $this->loginController->saveLogin($this->userLoginData);
                    $msg = \view\Messages::$welcome;
                } else {
                    $msg = \view\Messages::$wrongNameOrPassword;
                }
            }
        }

        $this->loginView->message($msg);
        return $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
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
