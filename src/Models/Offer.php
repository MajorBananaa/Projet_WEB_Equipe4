<?php
namespace App\Models;

use App\Models\Database;

class Offer extends Database {
    public function add($data) {}
    
    public function remove($id) {
        $sql = "DELETE FROM offre WHERE id_offres = ?;".

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute([$id]);
        $this->close();

    }
    
    public function update($data) {}
    
    public function get($id) {}
    
    public function getAll($filters) {
        $sql = 
           "SELECT t1.id_offres, t1.titre, t1.description, t1.salaire, t1.teletravail, t1.duree, t2.niveau_etude, t3.type_contrat, t4.secteur, t5.nom 
            FROM `offre` t1
            JOIN etude t2 ON t1.id_etude = t2.id_etude
            JOIN contrat t3 ON t1.id_contrat = t3.id_contrat
            JOIN secteur t4 ON t1.id_secteur = t4.id_secteur
            JOIN entreprise t5 ON t1.id_entreprise = t5.id_entreprise
            WHERE 1=1
        ";
    
        $params = [];

        // Assurer que la recherche reste active même avec des filtres
        if (!empty($filters['search'])) {
            $sql .= " AND t1.titre LIKE ?";
            $params[] = "%" . $filters['search'] . "%";
        }

        if (!empty($filters['contrats'])) {
            $placeholders = implode(',', array_fill(0, count($filters['contrats']), '?'));
            $sql .= " AND t3.type_contrat IN ($placeholders)";
            $params = array_merge($params, $filters['contrats']);
        }

        if (!empty($filters['salaire'])) {
            $sql .= " AND t1.salaire >= ?";
            $params[] = $filters['salaire'];
        }

        if ($filters['teletravail'] === 'oui') {
            $sql .= " AND t1.teletravail = 1";
        }

        if (!empty($filters['duree'])) {
            $sql .= " AND t1.duree = ?";
            $params[] = $filters['duree'];
        }

        if (!empty($filters['niveau_etude'])) {
            $sql .= " AND t2.niveau_etude = ?";
            $params[] = $filters['niveau_etude'];
        }

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, true);
        $this->close();

        return $result ?: [];
    }
}