<?php
namespace App\Models;
use App\Models\Database;
class Evaluation extends Database
{
    public function add($data)
    {
        $sql = "INSERT INTO evaluation (id_eval, note, id_entreprise, id_utilisateur)
                VALUES (?,?,?,?);";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        $this->close();

        return $result;
    }


    public function removeEval($id)
    {
        $sql = "DELETE FROM evaluation 
                WHERE id_eval = ? 
                AND id_utilisateur = ?;";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($id);
        $this->close();

        return $result;
    }


    public function update($data)
    {
    }

    public function get($id)
    {
        $sql = "SELECT t1.id_eval, t1.note, t1.id_entreprise, t1.id_utilisateur, 
                       t2.nom AS entreprise_nom, t3.nom AS utilisateur_nom
                FROM evaluation t1
                JOIN entreprise t2 ON t1.id_entreprise = t2.id_entreprise
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur
                WHERE t1.id_eval = :id";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id]);
        $this->close();

        return $result ? $result[0] : null; // Retourne l'évaluation ou null si introuvée
    }

    public function getAll($id)
    {
        $sql = "SELECT o.id_entreprise, o.titre AS nom_offre, o.salaire 
                FROM wish_lister wl 
                JOIN offre o ON wl.id_offres = o.id_offres 
                WHERE wl.id_utilisateur = :id";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();

        return $result ?: [];
    }
}