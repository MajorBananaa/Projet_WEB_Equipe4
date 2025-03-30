<?php 
namespace App\Controllers;

use App\Models\Database;

class ControllerPage {

    private $templateEngine = null;

    public function __construct($templateEngine) {
        $this->templateEngine = $templateEngine;
    }

    public function welcomePage() {
        echo $this->templateEngine->render('index.html.twig');
    }

    public function showSearchOffer() {
        $search = new SearchController();
        $varSearch = $search->searchOffer();

        $offresParPage = 10;
        $pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $totalOffres = count($varSearch);
        $totalPages = ceil($totalOffres / $offresParPage);

        $offresPage = array_slice($varSearch, ($pageActuelle - 1) * $offresParPage, $offresParPage);

        echo $this->templateEngine->render('offer.html.twig', [
            'offres' => $offresPage,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages
        ]);
    }

    public function showSearchEntreprise() {
        // Show search entreprise page
    }

    public function showSearchStudent() {
        // Show search student page
    }

    public function showSearchPilote() {
        // Show search pilote page
    }

    public function showProfilStudent() {
        // Show student profile page
    }

    public function showProfilEntreprise() {
        // Show entreprise profile page
    }

    public function showDashboardStudent() {
        // Show student dashboard
    }

    public function showDashboardPilote() {
        // Show pilote dashboard
    }

    public function showAPropos() {
        echo $this->templateEngine->render('a-propos.html.twig');
    }

    public function showLogin($auth) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                if ($auth->login()) {
                    header("Location: /");
                    exit();
                } else {
                    header("Location: /login");
                    exit();
                }
            }
        }
        echo $this->templateEngine->render('login.html.twig');
    }
}
