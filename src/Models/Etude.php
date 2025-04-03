<?php
namespace App\Models;

use App\Models\Database;

class Etude extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {

        $sql = "SELECT * FROM secteur WHERE id_secteur = :id'";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["id" => $id], false);
        $this->close();
        
        return $result ?: [];
    }
    
    public function getAll() {
        $sql = 'SELECT * FROM etude';

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();

        return $result ?: [];
    }
}

?>