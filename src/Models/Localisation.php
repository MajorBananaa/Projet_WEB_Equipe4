<?php
namespace App\Models;

use App\Models\Database;

class Localisation extends Database {
    public function add($data) {
        $sql = "INSERT INTO localisation (pays, ville, adresse, code_postal)
                VALUES (?, ?, ?, ?);";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        
        return $result ?: [];
    }
    

    public function getLastId() {
        $sql = "SELECT LAST_INSERT_ID() AS id_localisation;";
        
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, false);
        $this->close();
        
        return $result ?: [];
    }

    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $sql = "SELECT * FROM localisation WHERE id_localisation = :id";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["id" => $id], false);
        $this->close();
        
        return $result ?: [];
    }
    
    public function getAll() {
        $sql = "SELECT * FROM localisation";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();
        
        return $result ?: [];
    }
}

?>