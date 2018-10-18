<?php
namespace view;

class RegisterView extends FormView {
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private static $register = 'RegisterView::Register';

    private $message = '';

    public function response($isLoggedin): string {
        return '<h2>Register a new user</h2>
			<form method="post" >
				<fieldset>
                    <legend>Register a new user - Write username and password</legend>

					<p id="' . self::$messageId . '">' . $this->message . '</p>

					<label for="' . self::$name . '">Username :</label>
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . strip_tags($this->getPost(self::$name)) . '" /><br>

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" /><br>

					<label for="' . self::$passwordRepeat . '">Repeat password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" /><br>

					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
        ';
    }

    public function getUserName(): string {
        return $this->getPost(self::$name);
    }

    public function getPassword(): string {
        return $this->getPost(self::$password);
    }

    public function getPasswordRepeat(): string {
        return $this->getPost(self::$passwordRepeat);
    }

    private function getPost($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return $_POST[$name];
        } else {
            return false;
        }
    }

    public function message($msg): void {
        $this->message = $msg;
    }
}
