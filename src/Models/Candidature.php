<?php
namespace App\Models;
use App\Models\Database;

class Candidature extends Database {
    public function add($data) {
        $sql = "INSERT INTO candidature (id_offres, id_utilisateur, date_candidature, chemin_cv, lettre_motivation) 
            VALUES (?, ?, CURDATE(), ?, ?);";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->sth->execute($data);
        $this->close();
        return $result ?:[];
    }
    
    public function remove($id) {}
    
    public function update($data) {}
    
    public function get($idUtilisateur, $idRole) {
            $sql = "SELECT t1.id_postuler, t1.date_candidature,
                        t2.titre AS offre_titre, t3.nom AS utilisateur_nom
                    FROM candidature t1
                    JOIN offre t2 ON t1.id_offres = t2.id_offres
                    JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur";
            $params = [];

        if ($idRole == 3){
        $sql .= " WHERE t1.id_utilisateur = ?";
        $params[] = $idUtilisateur;
        }

        elseif ($idRole == 2){
            $sql_promotion = "SELECT(t3.id_promotion) 
            FROM Appartenir t3
            WHERE t3.id_utilisateur = ?";
            $params2[] = $idUtilisateur;
    
            $this->connect();
            $this->sth = $this->dbh->prepare($sql_promotion);
            $promo = $this->execute($params2, false);
    
            $id_promotion = $promo->id_promotion;
            
            $this->close();
    
            $sql .= " JOIN appartenir t4 ON t3.id_utilisateur = t4.id_utilisateur
           		 	WHERE t4.id_promotion=?";
            $params[] = $id_promotion;    

        }

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, true);
        $this->close();
        
        return $result;
    }
    
    public function getAll() {
        $sql = "SELECT t1.id_postuler, t1.date_candidature, t1.chemin_cv, t1.lettre_motivation,
                       t2.titre AS offre_titre, t3.nom AS utilisateur_nom
                FROM candidature t1
                JOIN offre t2 ON t1.id_offres = t2.id_offres
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true); 
        $this->close();
        
        return $result ?: []; 
    }
}