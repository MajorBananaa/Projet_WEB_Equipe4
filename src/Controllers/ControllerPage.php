<?php 
namespace App\Controllers;
class ControllerPage {

    private $templateEngine = null;
    public $right = null;

    public function __construct($templateEngine) {
        $this->templateEngine = $templateEngine;
    }

    public function set($rights_user) : void {
        $this->right = $rights_user;
    }
    public function welcomePage() {
        echo $this->templateEngine->render('index.html.twig',['session' => $_SESSION, 'droits' => $this->right]);
    }

    public function showSearchOffer() {
        $search = new SearchController();
        $varSearch = $search->searchOffer();
        $pagination = $search->paginate($varSearch);
        
        echo $this->templateEngine->render('offer.html.twig', [
            'offres' => $pagination['data'],
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'contrats' => $_GET['contrat'] ?? [],
            'salaire' => $_GET['salaire'] ?? 0,
            'teletravail' => $_GET['teletravail'] ?? '',
            'duree' => $_GET['duree'] ?? '',
            'niveau_etude' => $_GET['niveau_etude'] ?? '',
            'droits' => $this->right
        ]);
    }

    public function showSearchEntreprise() {
        $search = new SearchController();
        $varSearch = $search->searchCompany();
        $pagination = $search->paginate($varSearch);
        
        echo $this->templateEngine->render('company.html.twig', [
            'entreprises' => $pagination['data'],
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'secteur' => $_GET['secteur'] ?? '',
            'droits' => $this->right
        ]);
    }

    public function showSearchStudent() {
        $search = new SearchController();
        $varSearch = $search->searchStudent();
        $pagination = $search->paginate($varSearch);
        
        echo $this->templateEngine->render('search-student.html.twig', [
            'students' => $pagination['data'],
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'droits' => $this->right
        ]);
    }


    public function showSearchPilote() {
        // Show search pilote page
    }

    public function showProfilStudent($id) {
        $profil = new ProfilController($id);
        $resultat = $profil->getProfilStudent();
        echo $this->templateEngine->render('student-profil.html.twig', [
            'entreprise' => $resultat
        ]);
    }

    public function showProfilEntreprise() {
        if (isset($_GET["id_entreprise"])){
            $company = new ProfilController($_GET["id_entreprise"]);
            $resultat = $company->getProfilEntreprise();
            echo $this->templateEngine->render('entreprise-profil.html.twig', ['entreprise' => $resultat]);
        } else {
            echo "Entreprise not found";
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
