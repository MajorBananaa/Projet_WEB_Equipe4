<?php
namespace App\Models;

use App\Models\Database;

class Wishlist extends Database {
    public function addWish($data) {
        $sql = "INSERT INTO wish_lister (id_utilisateur, id_offres)
                VALUES (?, ?);";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        $this->close();

        return $result;
    }
    
    public function removeWish($id) {
        $sql = "DELETE FROM wish_lister
                WHERE id_utilisateur = ? 
                AND id_offres = ?";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($id);
        $this->close();

        return $result;
    }
    
    public function update($data) {}
    
    public function get($idUtilisateur, $idRole) {
        $sql = "SELECT o.titre AS nom_offre, o.salaire 
        FROM wish_lister wl 
        JOIN offre o ON wl.id_offres = o.id_offres 
        WHERE wl.id_utilisateur = :id;";
        
        if($idRole == 2 || 1 ){
            $sql .= "";
        }

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $idUtilisateur], true);
        $this->close();
        
        return $result;
    }
    
    public function getAll($id) {
        $sql = "SELECT o.id_offres, o.titre AS nom_offre, o.salaire 
        FROM wish_lister wl 
        JOIN offre o ON wl.id_offres = o.id_offres 
        WHERE wl.id_utilisateur = :id";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id], true);
        $this->close();
        
        return $result;
    }
}