<?php 
namespace App\Controllers;
class ControllerPage {

    private $templateEngine = null;

    public function __construct($templateEngine) {
        $this->templateEngine = $templateEngine;
    }

    
    /**
     * Affiche la page 'index.html.twig'
     *
     * 
     */
    public function welcomePage() {
        echo $this->templateEngine->render('index.html.twig');
    }


    
    /**
     * affiche la page 'offer.html.twig' avec toutes les variables nécéssaire
     *(contrat, offres, teletravail etc..)
     * avec un conteur de page pour l'affichage des offres de l'entreprise
     */
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
    
    /**
     * affiche la page 'company.html.twig' avec toutes les variables nécéssaire
     *(contrat, offres, teletravail etc..)
     * avec un conteur de page pour l'affichage des offres de l'entreprise
     */

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

    public function showProfilEntreprise() {
        if (isset($_GET['identreprise'])){
            $company = new ProfilController($_GET['identreprise']);
            $resultat = $company->getProfilEntreprise();
            echo $this->templateEngine->render('entreprise-profil.html.twig', ['entreprise' => $resultat[0], 'offres' => $resultat[1]]);
        } else{
            echo '404 Not Found <br>';

        }
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
