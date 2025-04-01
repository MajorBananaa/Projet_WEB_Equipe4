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

    public function showSearchOffer($rights_user) {
        $search = new SearchController();
        $varSearch = $search->searchOffer();
    
        $offresParPage = 10;
        $totalOffres = count($varSearch);
        $totalPages = max(1, ceil($totalOffres / $offresParPage));
    
        $pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageActuelle = max(1, min($pageActuelle, $totalPages));
        $offresPage = array_slice($varSearch, ($pageActuelle - 1) * $offresParPage, $offresParPage);
    
        echo $this->templateEngine->render('offer.html.twig', [
            'offres' => $offresPage,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'search' => $_GET['search-bar'] ?? '',
            'contrats' => $_GET['contrat'] ?? [],
            'salaire' => $_GET['salaire'] ?? 0,
            'teletravail' => $_GET['teletravail'] ?? '',
            'duree' => $_GET['duree'] ?? '',
            'niveau_etude' => $_GET['niveau_etude'] ?? '',
            'droits' => $rights_user
        ]);
        
    }
    
    

    public function showSearchEntreprise($rights_user) {
        /*
        $search = new SearchController();
        $varSearch = $search->searchCompany();
    
        $offresParPage = 10;
        $totalOffres = count($varSearch);
        $totalPages = max(1, ceil($totalOffres / $offresParPage));
    
        $pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageActuelle = max(1, min($pageActuelle, $totalPages));
        $offresPage = array_slice($varSearch, ($pageActuelle - 1) * $offresParPage, $offresParPage);
*/

        echo $this->templateEngine->render('company.html.twig', [

        ]);
        
    }

    public function showSearchStudent() {
        // Show search student page
    }

    public function showSearchPilote() {
        // Show search pilote page
    }

    public function showProfilStudent($id) {
        $profil = new ProfilController($id);
        $resultat = $profil->getProfilStudent();
        echo $this->templateEngine->render('student-profil.html.twig', [
            'student' => $resultat['student'][0],
            'place' => $resultat['place'][0]
        ]);
    }

    public function showProfilEntreprise($id) {
        $company = new ProfilController($id);
        $resultat = $company->getProfilEntreprise();
        echo $this->templateEngine->render('entreprise-profil.html.twig', ['entreprise' => $resultat['entreprise'][0], 'offers' => $resultat['offers'], 'place' => $resultat['place'][0], 'secteur' => $resultat['secteur'][0]]);
        // Show entreprise profile page
    }

    public function showDashboardStudent() {
        echo $this->templateEngine->render('dashboard.html.twig');
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
