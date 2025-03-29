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
if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] !== '/login') {
    header("Location: /login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        if ($auth->login()) {
            header("Location: /");
            exit();
        } else {
            header("Location: /login");
            exit();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === "logout") {
        $auth->logout();
        header("Location: /login");
        exit();
    }
}

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
        break;
}