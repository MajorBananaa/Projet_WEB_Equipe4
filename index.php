<?php
/**
 * This is the router, the main entry point of the application.
 * It handles the routing and dispatches requests to the appropriate controller methods.
 */

require "vendor/autoload.php";

use App\Controllers\ControllerPage;

$loader = new \Twig\Loader\FilesystemLoader('src/Views');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri)[0];
$uri = str_replace('/index.php', '', $uri);

if ($uri == '' || $uri == '/') {
    $uri = '/';
}

$controller = new ControllerPage($twig);

switch ($uri) {
    case '/':
        $controller->welcomePage();
        break;
    case '/offer':
        $controller->offerPage();
        break;
    case '/login':
        $controller->loginPage();
        break;
    default:
        echo '404 Not Found';
        break;
}