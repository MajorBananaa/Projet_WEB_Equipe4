<?php
session_start();
require "vendor/autoload.php";

use App\Controllers\ControllerPage;
use App\Controllers\ControllerAuthentification;
use App\Models\Entreprise;

$loader = new \Twig\Loader\FilesystemLoader('src/Views');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);


if (isset($_GET['uri'])) {
    $uri = $_GET['uri'];
} else {
    $uri = '/';
}


$auth = new ControllerAuthentification();
$controller = new ControllerPage($twig);
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
    $controller->right = $rights_user;
}


switch ($uri) {
    case '/':
        $controller->welcomePage();
        break;
    case '/offer':
        $controller->showSearchOffer($rights_user);
        break;
    case '/company':
        $controller->showSearchEntreprise($rights_user);
        break;
    case '/profil-company':
        $controller->showProfilEntreprise();
        break;
    case '/login':
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit();
        }
        $controller->showLogin($auth);
        break;
    case '/dashboard':
        $controller->showDashboardStudent();
        break;
    default:
        echo '404 Not Found <br>';
        break;
}