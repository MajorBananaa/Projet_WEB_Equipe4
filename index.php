<?php
session_start();
require "vendor/autoload.php";

use App\Controllers\ControllerPage;
use App\Controllers\SearchController;
use App\Controllers\ControllerAuthentification;

$loader = new \Twig\Loader\FilesystemLoader('src/Views');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);


if (isset($_GET['uri'])) {
    $uri = $_GET['uri'];
} else {
    $uri = '/';
}

$controller = new ControllerPage($twig);
$auth = new ControllerAuthentification();

//Redirection login si non connecté
if (!isset($_SESSION['user_id']) && $uri != "/login") {
    $controller->showLogin($auth);
    exit();
} elseif (isset($_POST['action']) && $_POST['action'] === "logout") {
    $auth->logout();
    $controller->showLogin($auth);
    exit();
}

if (isset($_SESSION['user_id'])) {
    $rights_user = $auth->getRight();
}

switch ($uri) {
    case '/':
        $controller->welcomePage();
        break;
    case '/offer':
        $controller->showSearchOffer($rights_user);
        break;
    case '/login':
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit();
        }
        $controller->showLogin($auth);
        break;
    case '/company':
        $controller->showSearchEntreprise($rights_user);
        break;
    case '/dashboard':
        $controller->showDashboardStudent();
        break;
    default:
        //echo '404 Not Found <br>';
        //break;
        $controller->showProfilEntreprise();
        break;
}

