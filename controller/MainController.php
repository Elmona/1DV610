<?php
namespace controller;

class MainController {
    private $loginView;
    private $registerView;
    private $dateTimeView;
    private $layoutView;

    private $loginController;
    private $database;

    public function __construct() {
        $this->layoutView = new \view\LayoutView();
        $this->loginView = new \view\LoginView();
        $this->registerView = new \view\RegisterView();
        $this->dateTimeView = new \view\DateTimeView();

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

    private function loginByCookie(): bool {
        if ($this->loginController->isLoggedInByCookie()) {
            $this->loginView->message(\view\Messages::$welcomeBackWithCookie);
            return true;
        } else {
            $this->loginView->message(\view\Messages::$wrongInformationInCookies);
            return false;
        }
    }

    private function logout(): bool {
        $this->loginController->logout();
        $this->loginView->message(\view\Messages::$byeBye);

        return false;
    }

    private function register(): bool {
        try {
            if ($this->loginView->isPost()) {
                $registerData = new \model\RegisterData($this->registerView->getUserName(),
                    $this->registerView->getPassword(), $this->registerView->getPasswordRepeat());

                if ($this->database->registerNewUser($registerData)) {
                    $this->loginView->message(\view\Messages::$registeredNewUser);
                    $this->loginView->registeredUsername($registerData->username());

                    return true;
                } else {
                    $this->registerView->msg(\view\Messages::$userExists);
                }
            }
        } catch (\Exception $e) {
            $this->registerView->msg($e->getMessage());
        }

        return false;
    }

    private function login(): bool {
        try {
            $userLoginData = new \model\UserLoginData($this->loginView->getUserName(),
                $this->loginView->getPassword(), false);

            if ($this->database->testcredentials($userLoginData)) {
                $this->loginController->saveLogin($userLoginData);
                $this->loginView->message(\view\Messages::$welcome);
                return true;
            } else {
                $this->loginView->message(\view\Messages::$wrongNameOrPassword);
            }
        } catch (\Exception $e) {
            $this->loginView->message($e->getMessage());
        }

        return false;
    }
}
