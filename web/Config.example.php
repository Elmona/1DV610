<?php

$_ENV['display_errors'] = 'Off';
$_ENV['timezone'] = 'Europe/Stockholm';
$_ENV['pepper'] = 'mySecret';

class Config {
    public $host = 'mysqlDB';
    public $user = 'dev';
    public $password = 'dev';
    public $database = 'test';
    public $port = '3306';
}
