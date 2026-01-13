<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
var_dump($_SERVER['DB_HOST']);
var_dump($_SERVER['DB_NAME']);
require_once __DIR__ . '/../routes/web.php';
echo $_ENV['APP_NAME']; // CoachPro
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
