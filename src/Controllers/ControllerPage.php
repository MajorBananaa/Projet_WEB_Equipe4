<?php
namespace App\Controllers;

use App\Models\Wishlist;
use App\Models\Evaluation;
class ControllerPage
{

    private $templateEngine = null;
    public $right = null;

    /**
     * Constructeur de la classe, initialise l'objet avec le moteur de template spécifié.
     *
     * @param object $templateEngine Instance du moteur de template utilisé pour générer les vues.
     */
    public function __construct($templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }


    /**
     * Définit les droits de l'utilisateur.
     *
     * @param mixed $rights_user Droits à attribuer à l'utilisateur.
     * @return void
     */
    public function set($rights_user): void
    {
        $this->right = $rights_user;
    }

    /**
     * Affiche la page d'accueil en utilisant le moteur de template.
     *
     * Cette méthode rend le fichier `index.html.twig` en passant les informations
     * de session et les droits de l'utilisateur au template.
     *
     * @return void
     */
    public function welcomePage()
    {
        echo $this->templateEngine->render('index.html.twig', ['session' => $_SESSION, 'droits' => $this->right]);
    }


    /**
     * Affiche la page des offres de stage avec les résultats de la recherche et les filtres appliqués.
     *
     * Cette méthode :
     * - Récupère les résultats de la recherche via `SearchController`.
     * - Applique les filtres et la pagination.
     * - Récupère la liste des offres en wishlist de l'utilisateur.
     * - Rend le template `offer.html.twig` en lui passant les données nécessaires.
     *
     * @return void
     */
    public function showSearchOffer()
    {
        $search = new SearchController();
        $varSearch = $search->searchOffer();
        $filters = $search->addModifFilter();
        $pagination = $search->paginate($varSearch);

        $dbWish = new Wishlist();
        $wishOffers = $dbWish->getAll($_SESSION["user_id"]);

        echo $this->templateEngine->render('offer.html.twig', [
            'offres' => $pagination['data'],
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'contrat' => $_GET['contrat'] ?? [],
            'salaire' => $_GET['salaire'] ?? 0,
            'teletravail' => $_GET['teletravail'] ?? '',
            'duree' => $_GET['duree'] ?? '',
            'niveau_etude' => $_GET['niveau_etude'] ?? '',
            'droits' => $this->right,
            'wishlist' => $wishOffers,
            'entreprises' => $filters[0],
            'secteurs' => $filters[1],
            'contrats' => $filters[2],
            'etudes' => $filters[3]
        ]);
    }


    /**
     * Affiche la page des entreprises avec les résultats de la recherche et les filtres appliqués.
     *
     * Cette méthode :
     * - Récupère les résultats de la recherche via `SearchController`.
     * - Applique les filtres et la pagination.
     * - Récupère les évaluations des entreprises associées à l'utilisateur.
     * - Rend le template `company.html.twig` en lui passant les données nécessaires.
     *
     * @return void
     */
    public function showSearchEntreprise()
    {
        $search = new SearchController();
        $varSearch = $search->searchCompany();
        $filters = $search->addModifFilter();
        $pagination = $search->paginate($varSearch);

        $dbEval = new Evaluation();
        $evalOffers = $dbEval->getAll($_SESSION["user_id"]);

        echo $this->templateEngine->render('company.html.twig', [
            'entreprises' => $pagination['data'],
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'secteur' => $_GET['secteur'] ?? '',
            'secteurs' => $filters[1],
            'droits' => $this->right,
            'evaluation' => $evalOffers
        ]);
    }


    /**
     * Affiche la liste des étudiants avec les résultats de la recherche et la pagination appliquée.
     *
     * Cette méthode :
     * - Récupère les étudiants (utilisateurs avec un rôle spécifique) via `SearchController`.
     * - Applique la pagination aux résultats.
     * - Rend le template `search-user.html.twig` en lui passant les données nécessaires.
     *
     * @return void
     */
    public function showSearchStudent()
    {
        $search = new SearchController();
        $varSearch = $search->searchUser(id_role: 3);
        $pagination = $search->paginate($varSearch);

        echo $this->templateEngine->render('search-user.html.twig', [
            'users' => $pagination['data'],
            'user_name' => "étudiant",
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'droits' => $this->right
        ]);
    }



    /**
     * Affiche la liste des pilotes avec les résultats de la recherche et la pagination appliquée.
     *
     * Cette méthode :
     * - Récupère les pilotes (utilisateurs avec un rôle spécifique) via `SearchController`.
     * - Applique la pagination aux résultats.
     * - Rend le template `search-user.html.twig` en lui passant les données nécessaires.
     *
     * @return void
     */
    public function showSearchPilote()
    {
        $search = new SearchController();
        $varSearch = $search->searchUser(id_role: 2);
        $pagination = $search->paginate($varSearch);

        echo $this->templateEngine->render('search-user.html.twig', [
            'users' => $pagination['data'],
            'user_name' => "pilote",
            'pageActuelle' => $pagination['currentPage'],
            'totalPages' => $pagination['totalPages'],
            'search' => $_GET['search-bar'] ?? '',
            'droits' => $this->right
        ]);
    }


    /**
     * Affiche le profil d'un étudiant spécifique.
     *
     * Cette méthode :
     * - Récupère l'ID de l'étudiant via la méthode GET.
     * - Utilise `ProfilController` pour récupérer les informations du profil de l'étudiant.
     * - Rend le template `student-profil.html.twig` en lui passant les données nécessaires pour afficher le profil.
     *
     * @return void
     */
    public function showProfilStudent()
    {
        $id = $_GET['id_student'];
        $profil = new ProfilController($id);
        $resultat = $profil->getProfilStudent();

        echo $this->templateEngine->render('student-profil.html.twig', [
            'student' => $resultat['student'],
            'place' => $resultat['place'],
            'droits' => $this->right
        ]);
    }


    /**
     * Affiche le profil d'une entreprise spécifique.
     *
     * Cette méthode :
     * - Vérifie si l'ID de l'entreprise est passé via la méthode GET.
     * - Récupère les informations du profil de l'entreprise via `ProfilController`.
     * - Rend le template `entreprise-profil.html.twig` en lui passant les données nécessaires pour afficher le profil de l'entreprise et ses offres.
     * - Si l'ID de l'entreprise n'est pas trouvé, affiche un message d'erreur.
     *
     * @return void
     */
    public function showProfilEntreprise()
    {
        if (isset($_GET["id_entreprise"])) {
            $company = new ProfilController($_GET["id_entreprise"]);
            $resultat = $company->getProfilEntreprise();
            echo $this->templateEngine->render('entreprise-profil.html.twig', [
                'entreprise' => $resultat['entreprise'],
                'offers' => $resultat['offers'],
                'droits' => $this->right
            ]);
        } else {
            echo "Entreprise not found";
        }
    }


    /**
     * Affiche le tableau de bord avec les statistiques des candidats.
     *
     * Cette méthode :
     * - Récupère diverses statistiques sur les candidats via `DashboardController`.
     * - Récupère le nombre total de candidats, les candidats récents, les évaluations des candidats, les candidatures envoyées et les éléments de la wishlist.
     * - Rend le template `dashboard.html.twig` en lui passant les données nécessaires pour afficher les statistiques.
     *
     * @return void
     */
    public function showDashboard()
    {
        $candidat_stat = new DashboardController();
        $nb_candidat = $candidat_stat->searchDashboard();
        $nb_candidat_recentes = $candidat_stat->searchDashboardCandRecentes();
        $nb_candidat_evals = $candidat_stat->searchDashboardEval();
        $candidature_send = $candidat_stat->searchDashboardCandSend();
        $wish_list = $candidat_stat->searchDashboardWishList();

        echo $this->templateEngine->render('dashboard.html.twig', [
            'nb_candidature' => $nb_candidat->nb_cand,
            'nb_candidature_recentes' => $nb_candidat_recentes->nb_cand_recentes,
            'nb_evals' => $nb_candidat_evals->nb_eval,
            'candidatures' => $candidature_send,
            'wishlist' => $wish_list,
            'droits' => $this->right
        ]);
    }


    /**
     * Affiche la page "À propos".
     *
     * Cette méthode :
     * - Rend simplement le template `a-propos.html.twig`, sans données dynamiques.
     *
     * @return void
     */
    public function showAPropos()
    {
        echo $this->templateEngine->render('a-propos.html.twig');
    }


    /**
     * Affiche la page de connexion et gère l'authentification de l'utilisateur.
     *
     * Cette méthode :
     * - Vérifie si la méthode HTTP est `POST` pour tenter une authentification de l'utilisateur.
     * - Si l'utilisateur est authentifié avec succès via l'objet `$auth`, il est redirigé vers la page d'accueil.
     * - Si l'authentification échoue, l'utilisateur est redirigé vers la page de connexion.
     * - Si la méthode HTTP n'est pas `POST` ou si l'utilisateur est déjà connecté, le template `login.html.twig` est rendu.
     *
     * @param object $auth Instance de la classe responsable de l'authentification.
     * @return void
     */
    public function showLogin($auth)
    {
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
