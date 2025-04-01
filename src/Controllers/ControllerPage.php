<?php 
namespace App\Controllers;

use App\Controllers\ProfilController;
use App\Models\Localisation;

class ControllerPage {

    private $templateEngine = null;


    public function __construct($templateEngine) {
        $this->templateEngine = $templateEngine;
    }

    public function welcomePage() {
        echo $this->templateEngine->render('index.html.twig');
    }

    public function offerPage() {
        echo $this->templateEngine->render('offer.html.twig');
    }

    public function showSearchEntreprise() {
        $search = new SearchController();
        $varSearch = $search->searchOffer();
    
        $offresParPage = 10;
        $totalOffres = count($varSearch);
        $totalPages = max(1, ceil($totalOffres / $offresParPage));
    
        $pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageActuelle = max(1, min($pageActuelle, $totalPages));
        $offresPage = array_slice($varSearch, ($pageActuelle - 1) * $offresParPage, $offresParPage);
    
        echo $this->templateEngine->render('company.html.twig', [
            'offres' => $offresPage,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'search' => $_GET['search-bar'] ?? ''
        ]);
    }



    public function showSearchOffer() {
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
            'search' => $_GET['search-bar'] ?? ''
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
        echo $this->templateEngine->render('student-profil.html.twig', ['student' => $resultat['student'][0], 'place' => $resultat['place'][0]]);
    }

    public function showProfilEntreprise($id) {
        $company = new ProfilController($id);
        $resultat = $company->getProfilEntreprise();
        echo $this->templateEngine->render('entreprise-profil.html.twig', ['entreprise' => $resultat['entreprise'][0], 'offers' => $resultat['offers'], 'place' => $resultat['place'][0], 'secteur' => $resultat['secteur'][0]]);
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
}