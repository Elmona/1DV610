<?php

// Change for testing purpose

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

$lv->render(false, $v, $dtv);
