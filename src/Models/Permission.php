<?php
namespace App\Models;

use App\Models\Database;

class Permission extends Database {
    /**
     * Récupère toutes les permissions associées à un rôle donné.
     *
     * @param int $idRole L'identifiant du rôle.
     * @return array Retourne un tableau des identifiants de permissions associées au rôle.
     */
    public function getAll($idRole) {
        $sql = "SELECT id_permission FROM affecter WHERE id_role = :id_role";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["id_role" => $idRole], true);
        $this->close();
        
        return $result ?: [];
    }

    /**
     * Récupère la liste complète des permissions disponibles.
     *
     * @return array Retourne un tableau contenant les identifiants et noms des permissions.
     */
    public function getAllrole() {
        $sql = "SELECT id_permission, nom FROM permission";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();
        
        return $result ?: [];
    }
}