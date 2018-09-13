<?php

// Include the files needed.
require_once 'view/LoginView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';

// Show errors turn off in production.
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Create objects of the views.
$v = new view\LoginView();
$dtv = new view\DateTimeView();
$lv = new view\LayoutView();

if ($_SERVER['REQUEST_METHOD'] == 'POST'
    && $_POST['LoginView::UserName']
    && $_POST['LoginView::Password']) {
    // echo "Should try to check if user name and password is correct.";
    $lv->render(true, $v, $dtv);
} else {
    $lv->render(false, $v, $dtv);
}
