<?php 
namespace App\Controllers;
use App\Models\Candidature;
use App\Models\Offer;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Localisation;
use App\Models\Secteur;
use App\Models\Contrat;
use App\Models\Wishlist;

class SearchController {
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
            } elseif (isset($_POST["offer_id-supr"]) && isset($_POST["remove"])) {
                $dbOffer->remove($_POST["offer_id-supr"]);
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
        return [
            'offers'   => $offers ?: [],
            'wishlist' => $wishOffers
        ];
    }

    public function searchCompany() {
        $company = new Entreprise();
        $filters = [
            'search' => $_GET['search-bar'] ?? '',
            'secteur' => $_GET['secteur'] ?? "",
        ];

        return $company->getAll($filters) ?: [];
    }
}
