<?php
namespace App\Models;

use App\Models\Database;

class Etudiant extends Database {
    public function add($data) {}
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($id) {
        $r = $this->execute('SELECT * FROM utilisateur WHERE id_utilisateur = :id', ['id' => $id]);
        return $r;
    }
    
    public function getAll() {}
}

?>