<?php
namespace App\Models;
use App\Models\Database;

class Candidature extends Database {
    public function add($data) {
        $sql = "INSERT INTO candidature (id_offres, id_utilisateur, date_candidature, chemin_cv, lettre_motivation) 
            VALUES (?, ?, CURDATE(), ?, ?);";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->sth->execute($data);
        $this->close();
        return $result ?:[];
    }
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $sql = "SELECT t1.id_postuler, t1.date_candidature, t1.chemin_cv, t1.chemin_lettre_motivation,
                    t2.titre AS offre_titre, t3.nom AS utilisateur_nom
                FROM candidature t1
                JOIN offre t2 ON t1.id_offres = t2.id_offres
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur
                WHERE t1.id_utilisateur = :id";
         
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id], true);
        $this->close();
        
        return $result;
    }
    
    public function getAll() {
        $sql = "SELECT t1.id_postuler, t1.date_candidature, t1.chemin_cv, t1.chemin_lettre_motivation,
                       t2.titre AS offre_titre, t3.nom AS utilisateur_nom
                FROM candidature t1
                JOIN offre t2 ON t1.id_offres = t2.id_offres
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true); 
        $this->close();
        
        return $result ?: []; 
    }
}