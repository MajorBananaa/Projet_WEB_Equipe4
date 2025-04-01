<?php
namespace App\Models;

use App\Models\Database;

class Localisation extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $r = $this->execute('SELECT * FROM localisation WHERE id_localisation = :id', ['id' => $id]);
        return $r;
    }
    
    public function getAll() {}
}

?>