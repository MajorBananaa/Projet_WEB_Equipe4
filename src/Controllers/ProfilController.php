<?php
namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Localisation;
use App\Models\Entreprise;
use App\Models\Offer;
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

        $offre = new Offer();
        $offres = $offre->get($entreprise->id_offres);


        return [$entreprise, $offres];
    }
}