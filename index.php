<?php
session_start();
require_once 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Router.php';
require_once 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Model.php';
require_once 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Controller.php';
require_once 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'View.php';
require_once 'app' . DIRECTORY_SEPARATOR . 'config.php';


$router = new core\Router();
$router->run();
ini_set('display errors', 1);
error_reporting(E_ALL);
session_destroy();
