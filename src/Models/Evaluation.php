<?php
namespace App\Models;
use App\Models\Database;
class Evaluation extends Database
{
    /**
     * Ajoute une évaluation dans la base de données.
     *
     * Cette méthode insère une nouvelle évaluation dans la table `evaluation` avec les informations fournies (note, id_utilisateur, id_entreprise).
     * Elle retourne le résultat de l'exécution de la requête, qui peut être un booléen ou un objet selon l'implémentation de la méthode `execute`.
     *
     * @param array $data Les données de l'évaluation (note, id_utilisateur, id_entreprise).
     * 
     * @return array|bool|object Le résultat de l'exécution de la requête, qui peut être un tableau, un booléen ou un objet.
     */
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



    /**
     * Supprime une évaluation dans la base de données.
     *
     * Cette méthode supprime une évaluation de la table `evaluation` en fonction de l'ID de l'utilisateur et de l'ID de l'entreprise fournis.
     * Elle retourne le résultat de l'exécution de la requête, qui peut être un booléen ou un objet selon l'implémentation de la méthode `execute`.
     *
     * @param array $id Les identifiants de l'utilisateur et de l'entreprise à supprimer.
     * 
     * @return array|bool|object Le résultat de l'exécution de la requête, qui peut être un tableau, un booléen ou un objet.
     */
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

    /**
     * Récupère une évaluation spécifique en fonction de son identifiant.
     *
     * Cette méthode récupère une évaluation de la table `evaluation` en fonction de l'ID de l'évaluation spécifié.
     * Elle retourne les informations associées à l'évaluation, y compris les détails de l'entreprise et de l'utilisateur associés.
     * 
     * @param int $id L'identifiant de l'évaluation à récupérer.
     * 
     * @return array|bool|object L'évaluation correspondante sous forme de tableau ou d'objet, ou `null` si aucune évaluation n'a été trouvée.
     */
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