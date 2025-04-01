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
    
    public function get($id) {}
    
    public function getAll() {}
}