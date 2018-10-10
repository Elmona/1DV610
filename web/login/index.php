<?php

require_once 'model/Database.php';
require_once 'model/UserLoginData.php';
require_once 'model/RegisterData.php';
require_once 'model/Cookie.php';
require_once 'model/Session.php';

require_once 'controller/LoginController.php';
require_once 'controller/MainController.php';

require_once 'view/FormView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/Messages.php';

// I strongly advise you to change values in this file.
require_once '../Config.php';

error_reporting(E_ALL);
ini_set('display_errors', $_ENV['display_errors']);
date_default_timezone_set($_ENV['timezone']);
session_start();

try {
    $mc = new \controller\MainController();
    echo $mc->returnHTML();
} catch (Exception $e) {
    echo $e->getMessage();
}