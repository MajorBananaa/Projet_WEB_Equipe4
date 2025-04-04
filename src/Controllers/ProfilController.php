<?php
namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Localisation;
use App\Models\Entreprise;
use App\Models\Secteur;
use App\Models\Contrat;
use App\Models\Utilisateur;
use App\Models\Offer;
use App\Models\Candidature;





class ProfilController {

    private $id = 0;

    public function __construct($id) {
        $this->id = $id;        
    }

    public function getProfilStudent() {
        $etudiant = new Utilisateur();
        $student = $etudiant->get(['nom', 'prenom', 'email', 'chemin_profil_picture', 'description', 'id_localisation'], 'id_utilisateur', $this->id);
        $lieu = new Localisation();
        $place = $lieu->get($student->id_localisation);

        return [
            'student' => $student,
            'place' => $place
        ];;
    }

    public function getProfilEntreprise() {
        $company = new Entreprise();
        $entreprise = $company->get($this->id);
        $offre = new Offer();
        $offers = $offre->getE($entreprise->id_entreprise);

        $candidature = new Candidature();
        foreach($offers as $offre_s){
            $candidat = $candidature->getOffre($offre_s->id_offres);

            $offre_s->nbCandidats = $candidat->nbCandidats;


        }

        return ['entreprise' => $entreprise, 'offers' => $offers];
    }
}