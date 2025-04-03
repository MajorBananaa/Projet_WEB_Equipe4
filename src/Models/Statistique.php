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
    public function getAll($idUtilisateur, $idRole) {
    $sql = "SELECT COUNT(t1.id_postuler) 
    AS nb_cand
    FROM candidature t1";
    $params = [];

    if ($idRole == 3) { 
        $sql .= " AND t1.id_utilisateur = ?";
        $params[] = $idUtilisateur;
    }

    $this->connect();
    $this->sth = $this->dbh->prepare($sql);
    $result = $this->execute($params, false);
    $this->close();

    return $result ?: [0]; 
}

    public function getAllRecentes($idUtilisateur, $idRole) {
        $sql = "SELECT COUNT(date_candidature) 
        AS nb_cand_recentes 
        FROM candidature 
        WHERE date_candidature >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
        $params = [];


        if ($idRole == 2) { 
        }
    
        if ($idRole == 3) { 
            $sql .= "AND t1.id_utilisateur = ?";
            $params[] = $idUtilisateur;
        }

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, false);
        $this->close();
        
        return $result ?: [0];
    }

    public function getAllEvals($idUtilisateur, $idRole) {
        $sql = "SELECT COUNT(id_eval) 
        AS nb_eval 
        FROM evaluation";
        $params = [];
        
        if ($idRole == 2) { 
        }
    
        if ($idRole == 3) { 
            $sql .= "WHERE id_utilisateur=?";
            $params[] = $idUtilisateur;
        }
        

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, false);
        $this->close();
        
        return $result ?: [0];
    }
}
