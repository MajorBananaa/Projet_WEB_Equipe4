<?php
namespace App\Models;

use App\Models\Database;

class Offer extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {}
    
    public function getAll() {
        $sql = 
            "SELECT t1.titre, t1.description, t1.salaire, t1.teletravail, t1.duree, t2.niveau_etude, t3.type_contrat, t4.secteur, t5.nom FROM `offre` t1
            JOIN etude t2 ON t1.id_etude = t2.id_etude
            JOIN contrat t3 ON t1.id_contrat = t3.id_contrat
            JOIN secteur t4 ON t1.id_secteur = t4.id_secteur
            JOIN entreprise t5 ON t1.id_entreprise = t5.id_entreprise;
            ";
 
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();
        
        return $result ?: [];
    }
}