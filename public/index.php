<?php
require_once '../helpers.php';
require_once basePath('Router.php');
require_once basePath('Database.php');

// Instantiating the router
$router = new Router();

// Get routes
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);

