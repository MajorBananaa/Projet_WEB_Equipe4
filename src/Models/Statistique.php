<?php
namespace App\Models;

use App\Models\Database;

class Statistique extends Database {
    /**
     * Récupère toutes les permissions associées à un rôle donné.
     *
     * @param int $idRole L'identifiant du rôle.
     * @return array Retourne un tableau des identifiants de permissions associées au rôle.
     */
    public function getAll($idRole) {
        $sql = "SELECT COUNT(id_postuler) AS nb_cand FROM candidature WHERE id_utilisateur=?";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["$idRole"], false);
        $this->close();
        
        return $result ?: [];
    }
    public function getAllRecentes($idRole) {
        $sql = "SELECT COUNT(date_candidature) AS nb_cand_recentes FROM candidature WHERE date_candidature >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND id_utilisateur=?;";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["$idRole"], false);
        $this->close();
        
        return $result ?: [];
    }
    public function getAllEvals($idRole) {
        $sql = "SELECT COUNT(id_eval) AS nb_eval FROM evaluation WHERE id_utilisateur=?;";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["$idRole"], false);
        $this->close();
        
        return $result ?: [];
    }
}
