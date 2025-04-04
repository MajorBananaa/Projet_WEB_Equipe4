<?php
namespace App\Models;

use App\Models\Database;

class Contrat extends Database
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
     * Récupère les informations d'un secteur par son ID.
     *
     * Cette méthode effectue une requête SQL pour récupérer toutes les informations d'un secteur spécifique 
     * en fonction de son `id_secteur`. Elle retourne les données sous forme de tableau associatif ou un tableau vide 
     * si aucune donnée n'est trouvée ou en cas d'échec de la requête.
     *
     * @param int $id L'ID du secteur que l'on souhaite récupérer.
     *
     * @return array|bool|object Retourne :
     * - Un tableau associatif contenant toutes les informations du secteur si la requête s'exécute avec succès.
     * - Un tableau vide `[]` si aucune donnée n'est trouvée ou en cas d'échec.
     * - Un objet `PDOStatement` en cas d'échec dans l'exécution de la requête (selon l'implémentation de la méthode `execute`).
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
     * Récupère toutes les informations des contrats disponibles.
     *
     * Cette méthode effectue une requête SQL pour récupérer toutes les lignes de la table `contrat`. Elle retourne
     * les données sous forme de tableau associatif ou un tableau vide si aucune donnée n'est trouvée ou en cas d'échec
     * de la requête.
     *
     * @return array|bool|object Retourne :
     * - Un tableau associatif contenant toutes les informations des contrats si la requête s'exécute avec succès.
     * - Un tableau vide `[]` si aucune donnée n'est trouvée ou en cas d'échec de la requête.
     * - Un objet `PDOStatement` en cas d'échec dans l'exécution de la requête (selon l'implémentation de la méthode `execute`).
     */
    public function getAll()
    {
        $sql = 'SELECT * FROM contrat';

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();

        return $result ?: [];
    }

}

?>