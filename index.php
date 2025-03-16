<?php
/**
 * This is the router, the main entry point of the application.
 * It handles the routing and dispatches requests to the appropriate controller methods.
 */

require "vendor/autoload.php";

use App\Controllers\TaskController;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);

$uri = $_SERVER['REQUEST_URI'];

// Supprime les éventuels paramètres GET après "?"
$uri = explode('?', $uri)[0];

// Supprime "/index.php" s'il est présent dans l'URL
$uri = str_replace('/index.php', '', $uri);

// Si l'URI est vide ou "/", on met la page d'accueil
if ($uri == '' || $uri == '/') {
    $uri = '/';
}



$controller = new TaskController($twig);

switch ($uri) {
    case '/':
        $controller->welcomePage();
        break;
    case '/offer':
        $controller->offerPage();
        break;
    default:
        // TODO : return a 404 error
        echo '404 Not Found';
        break;
}