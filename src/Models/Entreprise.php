<?php
namespace App\Models;

use App\Models\Database;

class Entreprise extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $r = $this->execute('SELECT * FROM entreprise WHERE id_entreprise = :id', ['id' => $id]);
        return $r;
    }
    
    public function getAll() {}
}

?>