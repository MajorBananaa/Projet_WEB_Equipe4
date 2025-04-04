<?php
namespace App\Models;

use App\Models\Database;

class Etude extends Database
{
    public function add($data)
    {
    }

    public function remove($id)
    {
    }

    public function update($data)
    {
    }

    /**
     * Récupère les informations d'un secteur spécifique à partir de son ID.
     *
     * Cette méthode permet de récupérer toutes les informations du secteur correspondant à l'ID donné.
     *
     * @param int $id L'ID du secteur à récupérer.
     * 
     * @return array|bool|object Les informations du secteur ou un tableau vide si aucun secteur n'est trouvé.
     */
    public function get($id)
    {

        $sql = "SELECT * FROM secteur WHERE id_secteur = :id'";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(["id" => $id], false);
        $this->close();

        return $result ?: [];
    }


    /**
     * Récupère toutes les informations des études présentes dans la base de données.
     *
     * Cette méthode permet de récupérer toutes les informations contenues dans la table `etude`.
     * Elle renvoie un tableau contenant les données de toutes les études ou un tableau vide si aucune donnée n'est trouvée.
     * 
     * @return array|bool|object Un tableau des informations des études ou un tableau vide si aucune donnée n'est trouvée.
     */
    public function getAll()
    {
        $sql = 'SELECT * FROM etude';

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();

        return $result ?: [];
    }

}

?>