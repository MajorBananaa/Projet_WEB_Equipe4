<?php
namespace App\Models;
use App\Models\Database;
class Evaluation extends Database
{
    public function add($data)
    {
        $sql = "INSERT INTO evaluation (note, id_utilisateur, id_entreprise)
                VALUES (?,?,?);";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        $this->close();

        return $result;
    }


    public function removeEval($id)
    {
        $sql = "DELETE FROM evaluation 
                WHERE id_utilisateur = ? 
                AND id_entreprise = ?;";

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
        $result = $this->execute(['id' => $id], true);
        $this->close();

        return $result; // Retourne l'évaluation ou null si introuvée
    }

    public function getAll($id)
    {
        $sql = "SELECT t1.id_eval, t1.note, t1.id_entreprise, t1.id_utilisateur, 
                       t2.nom AS entreprise_nom, t3.nom AS utilisateur_nom
                FROM evaluation t1
                JOIN entreprise t2 ON t1.id_entreprise = t2.id_entreprise
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur
                WHERE t1.id_utilisateur = :id";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id], true);
        $this->close();

        return $result ?: [];
    }
}