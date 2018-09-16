<?php

// Include the files needed.
require_once 'model/Cookie.php';
require_once 'model/Globals.php';
require_once 'controller/RouteController.php';
require_once 'view/LoginView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';

require_once 'Config.php';

error_reporting(E_ALL);
ini_set('display_errors', $_ENV['display_errors']);
date_default_timezone_set($_ENV['timezone']);

$router = new controller\RouteController();
$router->route();
