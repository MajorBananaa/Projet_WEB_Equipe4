<?php 
namespace App\Controllers;
use App\Models\Offer;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Localisation;
use App\Models\Secteur;
use App\Models\Contrat;


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

    public function searchCompany() {


        $company = new Entreprise();
        $entreprise = $company->getAll();


        $lieu = new Localisation();
        $place = $lieu->get($entreprise[0]->id_localisation);


        $sector = new Secteur();
        $secteur = $sector->get($entreprise[0]->id_secteur);
        

        return [
            'entreprise' => $entreprise,
            'place' => $place,
            'secteur' => $secteur
        ];
    }
}
