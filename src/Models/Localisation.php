<?php
namespace App\Models;

use App\Models\Database;

class Localisation extends Database {
    public function add($data) {}
    
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
    
    public function getAll() {}
}

?>