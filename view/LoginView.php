<?php
namespace view;

use controller;

class LoginView {
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function response($isLoggedIn) {
        $msg = '';
        if ($isLoggedIn) {
            if ($this->getPost(self::$logout)) {
                controller\Login::logout();
                $msg = 'Goodbye!';
                return $this->generateLoginFormHTML($msg);
            }
            $response = $this->generateLogoutButtonHTML($msg);
        } else {
            if ($this->isPost() && $this->getPost(self::$name) && !$this->getPost(self::$password)) {
                $msg = 'Password is missing';
            } else if ($this->isPost() && !$this->getPost(self::$name)) {
                $msg = 'Username is missing';
            }

            if ($this->isPost() && $this->getPost(self::$name) && $this->getPost(self::$password)) {
                if ($this->testCredentials()) {
                    controller\Login::saveLogin();
                    $msg = 'Welcome';
                    return $this->generateLogoutButtonHTML($msg);
                } else {
                    $msg = 'Wrong name or password';
                }
            }
            $response = $this->generateLoginFormHTML($msg);
        }

        return $response;
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLogoutButtonHTML($message) {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLoginFormHTML($message) {
        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getPost(self::$name) . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    /**
     * Check if global variable is set and return it.
     *
     * @param [string] $name
     * @return string
     */
    public function getPost($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return $_POST[$name];
        } else {
            return null;
        }
    }

    /**
     * Check if server REQUEST_METHOD is post
     *
     * @return boolean
     */
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    private function testCredentials() {
        // TODO: Ask database.
        return $this->getPost(self::$name) == 'Admin' && $this->getPost(self::$password) == 'test';
    }
}
