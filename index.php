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

switch ($uri) {
    case '/':
        $controller->welcomePage();
        break;
    case '/offer':
        $controller->showSearchOffer();
        break;
    case '/login':
        header("Location: /");
        exit();
    default:
        echo '404 Not Found <br>';
        $test = new SearchController();
        $test->searchOffer();
        print_r($test);
        break;
}