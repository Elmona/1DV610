<?php
namespace view;

class LoginView extends \view\FormView {
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    private $message = '';
    private $newUsername = false;

    public function response($isLoggedIn): string {
        if ($isLoggedIn) {
            $response = $this->generateLogoutButtonHTML($this->message);
        } else {
            $response = $this->generateLoginFormHTML($this->message);
        }

        return $response;
    }

    private function generateLogoutButtonHTML($message): string {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    private function generateLoginFormHTML($message): string {
        $name;
        if ($this->newUsername) {
            $name = $this->newUsername;
        } else {
            $name = $this->getPost(self::$name);
        }

        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $name . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

                    <input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    public function getCookieName(): string {
        return self::$cookieName;
    }

    public function getCookiePassword(): string {
        return self::$cookiePassword;
    }

    public function registeredUsername($username): string {
        $this->newUsername = $username;
    }

    public function tryingToRegister(): bool {
        return isset($_GET['register']);
    }

    public function tryingToLogout(): string {
        return $this->getPost(self::$logout);
    }

    public function tryingToLogin(): bool {
        return $this->isPost() && !$this->tryingToLogout();
    }

    public function getUserName(): string {
        return $this->getPost(self::$name);
    }

    public function getPassword(): string {
        return $this->getPost(self::$password);
    }

    public function message($msg): void {
        $this->message = $msg;
    }

    private function getPost($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return $_POST[$name];
        } else {
            return false;
        }
    }

    public function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function getUserAgent(): string {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}
