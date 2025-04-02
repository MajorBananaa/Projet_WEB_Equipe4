<?php
namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Localisation;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Secteur;
use App\Models\Contrat;




class ProfilController {

    private $id = 0;

    public function __construct($id) {
        $this->id = $id;        
    }

    public function getProfilStudent() {
        $etudiant = new Etudiant();
        $student = $etudiant->get($this->id);
        $lieu = new Localisation();
        $place = $lieu->get($student[0]->id_localisation);
        return [
            'student' => $student,
            'place' => $place
        ];;
    }

    public function getProfilEntreprise() {


        $company = new Entreprise();
        $entreprise = $company->get($this->id);


        $lieu = new Localisation();
        $place = $lieu->get($entreprise[0]->id_localisation);


        $offre = new Offre();
        $offers = $offre->getAll();
        $filtre = array_filter($offers, function($item) {
            return $item->id_entreprise == 1;
        });
        $filtre = array_values($filtre);
        $offers = $filtre;


        $contratModel = new Contrat();
        foreach ($offers as $offer) {
            $contrat = $contratModel->get($offer->id_contrat);
            $offer->contrat_nom = $contrat[0]->type_contrat;
        }


        $sector = new Secteur();
        $secteur = $sector->get($entreprise[0]->id_secteur);
        

        return [
            'entreprise' => $entreprise,
            'offers' => $offers,
            'place' => $place,
            'secteur' => $secteur
        ];
    }
}