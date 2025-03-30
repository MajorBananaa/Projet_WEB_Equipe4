<?php
session_start();
require "vendor/autoload.php";

use App\Controllers\ControllerPage;
use App\Controllers\ControllerAuthentification;

$loader = new \Twig\Loader\FilesystemLoader('src/Views');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$auth = new ControllerAuthentification();
$auth->isLog();
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
        $controller->showSearchOffer();
        break;
    case '/login':
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit();
        }
        $controller->showLogin();
        break;
    default:
        echo '404 Not Found <br>';
        $auth->getRight();
        break;
}