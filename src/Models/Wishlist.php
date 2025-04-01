<?php
namespace App\Models;

use App\Models\Database;

class Wishlist extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $sql = "SELECT o.titre AS nom_offre, o.salaire 
        FROM wish_lister wl 
        JOIN offre o ON wl.id_offres = o.id_offres 
        WHERE wl.id_utilisateur = :id;";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id], true);
        $this->close();
        
        return $result;
    }
    
    public function getAll() {}
}