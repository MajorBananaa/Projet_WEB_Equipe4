<?php
namespace App\Models;
use App\Models\Database;

class Permission extends Database {
    public function get($id) {}
    public function getAll($idRole) {
        $sql = "SELECT id_permission FROM affecter WHERE id_role = :id_role";
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["id_role" => $idRole], true);
        $this->close();
        
        return $result ?: [];
    }

    public function getAllrole() {
        $sql = "SELECT id_permission FROM permission";
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();
        
        return $result ?: [];
    }
}