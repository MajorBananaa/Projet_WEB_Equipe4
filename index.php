<?php
session_start();
require "vendor/autoload.php";

use App\Controllers\ControllerPage;
use App\Controllers\ControllerAuthentification;
use App\Models\Statistique;
use App\Models\Candidature;

$loader = new \Twig\Loader\FilesystemLoader('src/Views');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$auth = new ControllerAuthentification();
$auth->isLog();

if (isset($_GET['uri'])) {
    $uri = $_GET['uri'];
} else {
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
    case '/dashboard':
        $controller->showDashboardStudent();
        break;
    default:
        echo '404 Not Found <br>';
        $test = new Candidature();
        $test2 = $test->get(20);
        print_r($test2);
        break;
}