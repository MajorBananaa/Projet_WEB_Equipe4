<?php
namespace App\Models;
use App\Models\Database;

class Utilisateur extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($select, $where) {
        $sql = $select . "FROM utilisateur " . $where;
        Database::connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = Database::execute(false);
        Database::close();
        return $result;
    }
    
    public function getAll() {}
}