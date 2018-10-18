<?php

require_once 'model/Database.php';
require_once 'model/UserLoginData.php';
require_once 'model/RegisterData.php';
require_once 'model/Cookie.php';
require_once 'model/Session.php';
require_once 'model/Exceptions.php';

require_once 'controller/LoginController.php';
require_once 'controller/MainController.php';

require_once 'view/FormView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/Messages.php';

class Login {
    public function returnHTML(): string {
        $mc = new \controller\MainController();
        return $mc->returnHTML();
    }
}
