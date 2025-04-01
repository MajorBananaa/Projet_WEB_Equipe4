<?php 
namespace App\Controllers;
use App\Models\Candidature;
use App\Models\Offer;

class SearchController {
    public function searchOffer() {
        $dbOffer = new Offer();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //print_r($_POST["remove"]);
            if (isset($_POST["motivation"]) && isset($_FILES["cv"]) && isset($_POST["offer_id"])) {
                $check_file = new UploadService();
                
                if ($check_file->handleUpload($_FILES["cv"])){
                    $pathFile = $check_file->pathFile($_FILES["cv"]);

                    $candidature = new Candidature();
                    $candidature->add([$_POST["offer_id"], $_SESSION["user_id"], $pathFile, $_POST["motivation"]]);
                }
            } elseif (isset($_POST["offer_id-supr"]) && isset($_POST["remove"])) {
                $dbOffer->remove($_POST["offer_id-supr"]);
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
}
