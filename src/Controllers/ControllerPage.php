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
        echo $this->templateEngine->render('offer.html.twig');
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
        echo $this->templateEngine->render('dashboard.html.twig');
    }

    public function showDashboardPilote() {
        // Show pilote dashboard
    }

    public function showAPropos() {
        echo $this->templateEngine->render('a-propos.html.twig');
    }

    public function showLogin() {
        echo $this->templateEngine->render('login.html.twig');
    }
}
