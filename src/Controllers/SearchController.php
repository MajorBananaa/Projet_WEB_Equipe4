<?php 
namespace App\Controllers;
use App\Models\Offer;

class SearchController {
    public function searchOffer() {
        $dbOffer = new Offer();
        
        $filters = [
            'search' => $_GET['search-bar'] ?? '',
            'contrats' => $_GET['contrat'] ?? [],
            'salaire' => $_GET['salaire'] ?? null,
            'teletravail' => $_GET['teletravail'] ?? '',
            'duree' => $_GET['duree'] ?? '',
            'niveau_etude' => $_GET['niveau_etude'] ?? ''
        ];
        
        return $dbOffer->getAll($filters);
    }
}