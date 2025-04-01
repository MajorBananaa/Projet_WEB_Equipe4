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
        $candidat_stat = new DashboardController();
        $nb_candidat = $candidat_stat->searchDashboard();
        $nb_candidat_recentes = $candidat_stat->searchDashboardCandRecentes();
        $nb_candidat_evals = $candidat_stat->searchDashboardEval();
        $candidature_send = $candidat_stat->searchDashboardCandSend();
        $wish_list = $candidat_stat->searchDashboardWishList();
        echo $this->templateEngine->render('dashboard.html.twig', [
            'nb_candidature' => $nb_candidat->nb_cand,
            'nb_candidature_recentes' => $nb_candidat_recentes->nb_cand_recentes,
            'nb_evals' =>$nb_candidat_evals->nb_eval,
            'candidature' =>$candidature_send,
            'wishlist' =>$wish_list
        ]);
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
