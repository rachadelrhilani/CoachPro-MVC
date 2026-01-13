<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
define('BASE_URL', $_ENV['APP_URL']); 
require_once __DIR__ . '/../routes/web.php';
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
