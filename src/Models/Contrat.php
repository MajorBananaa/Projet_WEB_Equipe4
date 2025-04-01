<?php
namespace App\Models;

use App\Models\Database;

class Contrat extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $r = $this->execute('SELECT * FROM contrat WHERE id_contrat = :id', ['id' => $id]);
        return $r;
    }
    
    public function getAll() {
        $r = $this->execute('SELECT * FROM contrat');
        return $r;
    }
}

?>