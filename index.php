<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

header('Content-Type: text/html; charset=utf-8');

require_once "vendor/autoload.php";

$route = new \app\helpers\Router();
$route->run();

