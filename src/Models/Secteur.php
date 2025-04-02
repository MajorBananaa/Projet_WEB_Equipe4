<?php
namespace App\Models;

use App\Models\Database;

class Secteur extends Database {
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
        $r = $this->execute('SELECT * FROM secteur');
        return $r;
    }
}

?>