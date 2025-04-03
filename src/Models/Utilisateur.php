<?php
namespace App\Models;
use App\Models\Database;

class Utilisateur extends Database
{
    public function add($data)
    {
        $sql = "INSERT INTO utilisateur (
            nom, 
            prenom, 
            description, 
            email, 
            telephone, 
            mots_de_passe, 
            chemin_profil_picture, 
            id_localisation, 
            id_role
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        $this->close();
    }

    public function remove($id)
    {
        $sql = "DELETE FROM utilisateur WHERE id_utilisateur = ?;" .

            $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute([$id]);
        $this->close();
    }

    public function update($data)
    {
        $sql = "UPDATE utilisateur SET 
                    nom = ?, 
                    prenom = ?, 
                    description = ?, 
                    email = ?, 
                    telephone = ?, 
                    mots_de_passe = ?, 
                    chemin_profil_picture = ?, 
                    id_localisation = ?, 
                    id_role = ?
                WHERE id_utilisateur = ?";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        $this->close();
    }

    public function get($selectList, $where, $var)
    {
        $sql = "SELECT " . implode(", ", $selectList) . " FROM utilisateur WHERE " . $where . " = :var";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['var' => $var], false);
        $this->close();
        return $result ?: [];
    }

    public function getAll($filters)
    {
        $sql = "SELECT id_utilisateur, nom, prenom, description, email, telephone, chemin_profil_picture, t2.ville 
        FROM utilisateur 
        JOIN localisation t2 ON utilisateur.id_localisation = t2.id_localisation
        WHERE 1=1";

        $params = [];
        if (!empty($filters['id_role'])) {
            $sql .= " AND id_role= ?";
            $params[] = $filters['id_role'];

        }

        if (!empty($filters['search'])) {
            $sql .= " AND (nom LIKE ? OR prenom LIKE ?)";
            $params[] = "%" . $filters['search'] . "%";
            $params[] = "%" . $filters['search'] . "%";
        }

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($params, true);
        $this->close();
        return $result ?: [];
    }
}