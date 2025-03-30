<?php
namespace App\Models;
use App\Models\Database;

class Utilisateur extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($selectList, $where, $var) {
        $sql = "SELECT " . implode(", ", $selectList) . " FROM utilisateur WHERE " . $where . " = :var";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['var' => $var], false);
        $this->close();
        
        return $result ?: [];
    }
    
    public function getAll() {}
}