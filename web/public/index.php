<?php

require_once '../Config.php';

require_once '../textSave/index.php';
require_once '../login/index.php';
require_once './ErrorPage500.php';

error_reporting(E_ALL);
ini_set('display_errors', $_ENV['display_errors']);
date_default_timezone_set($_ENV['timezone']);
session_start();

try {
    $login = new \Login();
    echo $login->returnHTML();
} catch (\Exception $e) {
    $errorPage500 = new \ErrorPage500();
    echo $errorPage500->returnHTML();
}
