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
    FROM Candidature t1";
    $params = [];

    if ($idRole == 2) { 
        $sql_promotion = "SELECT(t3.id_promotion) 
        FROM Appartenir t3
        WHERE t3.id_utilisateur = ?";
        $params2[] = $idUtilisateur;

        $this->connect();
        $this->sth = $this->dbh->prepare($sql_promotion);
        $promo = $this->execute($params2, false);

        $id_promotion = $promo->id_promotion;
        
        $this->close();

        $sql .= " JOIN Utilisateur t2 ON t1.id_utilisateur = t2.id_utilisateur
        JOIN Appartenir t3 ON t2.id_utilisateur = t3.id_utilisateur
        WHERE t3.id_promotion=?";
        $params[] = $id_promotion;
    }

    if ($idRole == 3) { 
        $sql .= " WHERE id_utilisateur = ?";
        $params[] = $idUtilisateur;
    }

    $this->connect();
    $this->sth = $this->dbh->prepare($sql);
    $result = $this->execute($params, false);
    $this->close();

    return $result ?: [0]; 
}

    public function getAllRecentes($idUtilisateur, $idRole) {
        $sql = "SELECT COUNT(t1.id_postuler) 
        AS nb_cand_recentes 
        FROM Candidature t1 
        WHERE t1.date_candidature >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
        $params = [];

        if ($idRole == 2) { 
            $sql_promotion = "SELECT(t3.id_promotion) 
            FROM Appartenir t3
            WHERE t3.id_utilisateur = ?";
            $params2[] = $idUtilisateur;
    
            $this->connect();
            $this->sth = $this->dbh->prepare($sql_promotion);
            $promo = $this->execute($params2,false);

            $id_promotion = $promo->id_promotion;
            
            $this->close();
    
            $sql .= " AND t1.id_utilisateur IN (SELECT t2.id_utilisateur FROM Appartenir t2 WHERE t2.id_promotion = ?)";
            $params[] = $id_promotion;
        }
    
        if ($idRole == 3) { 
            $sql .= " AND t3.id_utilisateur = ?";
            $params[] = $idUtilisateur;
        }

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, false);
        $this->close();
        
        return $result ?: [0];
    }

    public function getAllEvals($idUtilisateur, $idRole) {
        $sql = "SELECT COUNT(t1.id_eval) 
        AS nb_eval 
        FROM Evaluation t1";
        $params = [];

        
        if ($idRole == 2) { 
            $sql_promotion = "SELECT(t3.id_promotion) 
            FROM Appartenir t3
            WHERE t3.id_utilisateur = ?";
            $params2[] = $idUtilisateur;
    
            $this->connect();
            $this->sth = $this->dbh->prepare($sql_promotion);
            $promo = $this->execute($params2, false);
    
            $id_promotion = $promo->id_promotion;
            
            $this->close();
    
            $sql .= " JOIN Utilisateur t2 ON t1.id_utilisateur = t2.id_utilisateur
            JOIN Appartenir t3 ON t2.id_utilisateur = t3.id_utilisateur
            WHERE t3.id_promotion=?";
            $params[] = $id_promotion;
        }

        if ($idRole == 3) { 
            $sql .= " WHERE id_utilisateur = ?";
            $params[] = $idUtilisateur;
        }
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, false);
        $this->close();
        
        return $result ?: [0];
    }
}
