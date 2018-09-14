<?php

// Include the files needed.
require_once 'view/LoginView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'Config.php';

error_reporting(E_ALL);
ini_set('display_errors', $_ENV['display_errors']);
date_default_timezone_set($_ENV['timezone']);

// Create objects of the views.
$v = new view\LoginView();
$dtv = new view\DateTimeView();
$lv = new view\LayoutView();

// Router
if ($_SERVER['REQUEST_METHOD'] == 'POST'
    && $_POST['LoginView::UserName']
    && $_POST['LoginView::Password']) {
    $lv->render(true, $v, $dtv);
} else {
    $lv->render(false, $v, $dtv);
}
