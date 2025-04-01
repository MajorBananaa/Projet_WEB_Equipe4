<?php
namespace App\Models;
use App\Models\Database;
class Evaluation extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $sql = "SELECT t1.id_eval, t1.note, t1.id_entreprise, t1.id_utilisateur, 
                       t2.nom AS entreprise_nom, t3.nom AS utilisateur_nom
                FROM evaluation t1
                JOIN entreprise t2 ON t1.id_entreprise = t2.id_entreprise
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur
                WHERE t1.id_eval = :id";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id]);
        $this->close();
        
        return $result ? $result[0] : null; // Retourne l'évaluation ou null si introuvée
    }

    public function getAll() {
        $sql = "SELECT t1.id_eval, t1.note, t1.id_entreprise, t1.id_utilisateur, 
                       t2.nom AS entreprise_nom, t3.nom AS utilisateur_nom
                FROM evaluation t1
                JOIN entreprise t2 ON t1.id_entreprise = t2.id_entreprise
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true); 
        $this->close();
        
        return $result ?: []; 
    }
}