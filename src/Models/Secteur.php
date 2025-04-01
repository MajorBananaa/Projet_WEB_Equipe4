<?php
namespace App\Models;

use App\Models\Database;

class Secteur extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $r = $this->execute('SELECT * FROM secteur WHERE id_secteur = :id', ['id' => $id]);
        return $r;
    }
    
    public function getAll() {
        $r = $this->execute('SELECT * FROM secteur');
        return $r;
    }
}

?>