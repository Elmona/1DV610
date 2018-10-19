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
        $this->session = new \model\Session();

        $this->loginController = new \controller\LoginController($this->loginView, $this->database, $this->session);
    }

    public function returnHTML(): string {
        $isLoggedIn = $this->loginController->isLoggedInBySession();

        if ($this->loginView->tryingToRegister()) {
            if ($this->register()) {
                header('Location: /');
            } else {
                return $this->layoutView->render(false, $this->registerView, $this->dateTimeView);
            }
        } else if ($this->loginController->cookiesExist() && !$isLoggedIn) {
            $isLoggedIn = $this->loginByCookie();
        } else if ($this->loginView->tryingToLogin() && !$isLoggedIn) {
            $isLoggedIn = $this->login();
        } else if ($this->loginView->tryingToLogout() && $isLoggedIn) {
            $isLoggedIn = $this->logout();
        } else if ($this->session->isNewUserRegistered()) {
            $newUserName = $this->session->getNewRegisteredUserName();
            $this->loginView->registeredUsername($newUserName);
        }

        return $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
    }

    private function register(): bool {
        try {
            if ($this->loginView->isPost()) {
                $registerData = new \model\RegisterData($this->registerView->getUserName(),
                    $this->registerView->getPassword(), $this->registerView->getPasswordRepeat());

                if ($this->database->registerNewUser($registerData)) {
                    $this->session->newUserRegistered($registerData->username());

                    return true;
                } else {
                    $this->registerView->message(\view\Messages::$userExists);
                }
            }
        } catch (\PasswordDontMatch $e) {
            $this->registerView->message(\view\Messages::$passwordDontMatch);
        } catch (\ShortPassword $e) {
            $this->registerView->message(\view\Messages::$shortPassword);
        } catch (\ShortUserName $e) {
            $this->registerView->message(\view\Messages::$shortUsername);
        } catch (\ShortUserNameAndPassword $e) {
            $this->registerView->message(\view\Messages::$shortUsernameAndPassword);
        } catch (\InvalidChars $e) {
            $this->registerView->message(\view\Messages::$invalidChars);
        } catch (\Exception $e) {
            $this->registerView->message(\view\Messages::$unknownError);
        }

        return false;
    }

    private function loginByCookie(): bool {
        if ($this->loginController->isLoggedInByCookie()) {
            $this->loginController->saveLoginByCookie();
            $this->loginView->message(\view\Messages::$welcomeBackWithCookie);
            return true;
        } else {
            $this->loginView->message(\view\Messages::$wrongInformationInCookies);
            return false;
        }
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
        } catch (\UserNameMissing $e) {
            $this->loginView->message(\view\Messages::$usernameMissing);
        } catch (\PasswordMissing $e) {
            $this->loginView->message(\view\Messages::$passwordMissing);
        } catch (\Exception $e) {
            $this->loginView->message(\view\Messages::$unknownError);
        }

        return false;
    }

    private function logout(): bool {
        $this->loginController->logout();
        $this->loginView->message(\view\Messages::$byeBye);

        return false;
    }
}
