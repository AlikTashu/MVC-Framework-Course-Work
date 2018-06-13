<?php

// Добавлять в отчет все ошибки PHP
#error_reporting(-1);

use vendor\core\router\Router;
use vendor\core\router\Route;
use app\filters\UnavailablePageIFilter;
use \vendor\core\utility\Logger;
use vendor\core\exception;

session_start();
$query = $_SERVER["QUERY_STRING"];


define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');

//require "../vendor/core/Router.php";
require "../vendor/libs/functions.php";


//регистрируем функцию, которая будет инвокаться на use
spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

Router::add("", "home", "main");
Router::add("main", "home", "main");
Router::add("test", "main", "kek");
Router::add("catalog", "products", "catalog");
Router::add("product", "products", "product");
Router::add("bag", "products", "bag");
Router::add("register", "users", "registration");
Router::add("login", "users", "login");
Router::add("restore", "users", "restore");
Router::add("password", "users", "password");
Router::add("verify", "users", "verify");
Router::add("admin", "admin", "index");
Router::add("edit", "admin", "edit");

Router::add("checkout", "products", "checkout");


Logger::initialize();



try {
    Router::dispatch($query);
} catch (Throwable $e) {
    Logger::log($e->getMessage(), $e);
}
