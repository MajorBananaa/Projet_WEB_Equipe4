<?php
namespace App\Models;

use App\Models\Database;

class Entreprise extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($var) {
        $sql = "SELECT t1.id_entreprise, t1.nom, t1.description, t1.mail, t1.chemin_profil_entreprise, t2.ville, t3.secteur 
        FROM entreprise t1
        JOIN localisation t2 ON t1.id_localisation = t2.id_localisation
        JOIN secteur t3 on t1.id_secteur  = t3.id_secteur
        WHERE id_entreprise = :var";
 
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['var' => $var], false);
        $this->close();
        return $result ?: [];
    }
    
    public function getAll() {
        $sql = "SELECT * FROM entreprise";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();
        
        return $result ?: [];
    }
}

?>