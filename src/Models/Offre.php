<?php
namespace App\Models;

use App\Models\Database;

class Offre extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $r = $this->execute('SELECT * FROM offre WHERE id_offre = :id', ['id' => $id]);
        return $r;
    }
    
    public function getAll() {
        $r = $this->execute('SELECT * FROM offre');
        return $r;
    }
}

?>