<?php 
namespace App\Controllers;
use App\Models\Candidature;
use App\Models\Offer;
use App\Models\Entreprise;
use App\Models\Utilisateur;
use App\Models\Wishlist;
use App\Models\Evaluation;
class SearchController {
    public function paginate($data, $perPage = 10) {
        $totalItems = count($data);
        $totalPages = max(1, ceil($totalItems / $perPage));
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, min($currentPage, $totalPages));
        $pagedData = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
        
        return [
            'data' => $pagedData,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ];
    }
    public function searchOffer() {
        $dbOffer = new Offer();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["motivation"]) && isset($_FILES["cv"]) && isset($_POST["offer_id"])) {
                $check_file = new UploadService();
                
                if ($check_file->handleUpload($_FILES["cv"])){
                    $pathFile = $check_file->pathFile($_FILES["cv"]);

                    $candidature = new Candidature();
                    $candidature->add([$_POST["offer_id"], $_SESSION["user_id"], $pathFile, $_POST["motivation"]]);
                }
            } elseif (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $dbOffer->remove($_POST["id-supr"]);
            } elseif (isset($_POST["add"])) {
                $offre = [
                    'titre' => $_POST['titre'] ?? 'Titre par défaut',
                    'description' => $_POST['description'] ?? 'Description par défaut',
                    'salaire' => $_POST['salaire'] ?? 0,
                    'teletravail' => $_POST['teletravail'] ?? 0,
                    'duree' => $_POST['duree'] ?? 0,
                    'id_etude' => $_POST['id_etude'] ?? 0,
                    'id_contact' => $_POST['id_contact'] ?? 0,
                    'id_secteur' => $_POST['id_secteur'] ?? 0,
                    'id_entreprise' => $_POST['id_entreprise'] ?? 0
                ];

                $dbOffer->add($offre);
            } elseif (isset($_POST["update"])) {
                
                $offre = [
                    'id_offres' => $_POST['offer_id-upd'],
                    'description' => $_POST['description'] ?? 'Description par défaut',
                    'salaire' => $_POST['salaire'] ?? 0,
                    'teletravail' => $_POST['teletravail'] ?? 0,
                    'duree' => $_POST['duree'] ?? 0,
                    'id_etude' => $_POST['id_etude'] ?? 0,
                    'id_contrat' => $_POST['id_contrat'] ?? 0,
                    'id_secteur' => $_POST['id_secteur'] ?? 0
                ];
                $dbOffer->update($offre);
            } elseif (isset($_POST['offer_id-suprWish'])) {
                $dbwish = new Wishlist();
                $dbwish->removeWish([$_SESSION["user_id"], $_POST['offer_id-suprWish']]);
            } elseif (isset($_POST['offer_id-addWish'])) {
                $dbwishs = new Wishlist();
                $dbwishs->addWish([$_SESSION["user_id"], $_POST['offer_id-addWish']]);
            }   

            $_POST = [];
        }
        
        
        
        $filters = [
            'search' => $_GET['search-bar'] ?? '',
            'contrats' => $_GET['contrat'] ?? [],
            'salaire' => $_GET['salaire'] ?? null,
            'teletravail' => $_GET['teletravail'] ?? '',
            'duree' => $_GET['duree'] ?? '',
            'niveau_etude' => $_GET['niveau_etude'] ?? ''
        ];
        
        return $dbOffer->getAll($filters) ?: [];
    }

    public function searchCompany() {
        $company = new Entreprise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if  (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $company->remove($_POST["id-supr"]);
            } elseif (isset($_POST['offer_id-suprEval'])) {
                $dbeval = new Evaluation();
                $dbeval->removeEval([$_SESSION["user_id"], $_POST['offer_id-suprEval']]);
            } elseif (isset($_POST['offer_id-addEval'])) {
                $dbevals = new Evaluation();
                $dbevals->add([$_POST['offer_note-addEval'], $_SESSION["user_id"], $_POST['offer_id-addEval']]);
            }
            
            $_POST = [];
        }


        $filters = [
            'search' => $_GET['search-bar'] ?? '',
            'secteur' => $_GET['secteur'] ?? "",
        ];

        return $company->getAll($filters) ?: [];
    }

    public function searchUser($id_role) {
        $user = new Utilisateur();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if  (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $user->remove($_POST["id-supr"]);
            }
            $_POST = [];
        }

        $filters = [
            'id_role' => $id_role,
            'search' => $_GET['search-bar'] ?? '',
        ];

        return $user->getAll($filters) ?: [];
    }
}
