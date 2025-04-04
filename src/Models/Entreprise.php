<?php
namespace App\Models;

use App\Models\Database;

class Entreprise extends Database
{
    /**
     * Ajoute une nouvelle entreprise à la base de données.
     *
     * Cette méthode insère une nouvelle entreprise avec les informations fournies dans la table `entreprise`.
     *
     * @param array $data Les données à insérer dans la table (nom, description, mail, chemin du profil, id de localisation, id de secteur).
     * 
     * @return bool Retourne `true` si l'insertion a réussi, sinon `false`.
     */
    public function add($data)
    {
        $sql = "INSERT INTO entreprise (nom, description, mail, chemin_profil_entreprise, id_localisation, id_secteur)
                VALUES (?, ?, ?, ?, ?, ?);";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute($data);
        $this->close();

        return $result; // Cela peut être true ou false selon le succès de la requête.
    }


    /**
     * Supprime une entreprise de la base de données.
     *
     * Cette méthode supprime une entreprise de la table `entreprise` en fonction de son identifiant `id_entreprise`.
     *
     * @param int $id L'identifiant de l'entreprise à supprimer.
     * 
     * @return bool Retourne `true` si la suppression a réussi, sinon `false`.
     */
    public function remove($id)
    {
        // Prépare la requête SQL pour supprimer l'entreprise par son id_entreprise
        $sql = "DELETE FROM entreprise WHERE id_entreprise = ?;";

        // Connexion à la base de données
        $this->connect();

        // Préparation de la requête SQL
        $this->sth = $this->dbh->prepare($sql);

        // Exécution de la requête avec l'id de l'entreprise à supprimer
        $result = $this->execute([$id]);

        // Fermeture de la connexion à la base de données
        $this->close();

        // Retourne le résultat de l'exécution de la requête : true si réussite, false sinon
        return $result; // true ou false selon le succès de la suppression
    }


    /**
     * Met à jour les informations d'une entreprise dans la base de données.
     *
     * Cette méthode permet de mettre à jour les données d'une entreprise existante dans la table `entreprise`
     * en fonction de son identifiant `id_entreprise`.
     *
     * @param array $data Les données à mettre à jour dans la table (nom, description, mail, chemin du profil, id de localisation, id de secteur, id de l'entreprise).
     * 
     * @return bool Retourne `true` si la mise à jour a réussi, sinon `false`.
     */
    public function update($data)
    {
        // Prépare la requête SQL pour mettre à jour l'entreprise par son id_entreprise
        $sql = "UPDATE entreprise
                SET 
                    nom = ?,
                    description = ?,
                    mail = ?,
                    chemin_profil_entreprise = ?,
                    id_localisation = ?,
                    id_secteur = ?
                WHERE id_entreprise = ?;";

        // Connexion à la base de données
        $this->connect();

        // Préparation de la requête SQL
        $this->sth = $this->dbh->prepare($sql);

        // Exécution de la requête avec les données fournies
        $result = $this->execute($data);

        // Fermeture de la connexion à la base de données
        $this->close();

        // Retourne le résultat de l'exécution de la requête : true si réussite, false sinon
        return $result; // true ou false selon le succès de la mise à jour
    }


    /**
     * Récupère les informations d'une entreprise par son identifiant.
     *
     * Cette méthode permet de récupérer les détails d'une entreprise spécifique, incluant son nom, sa description,
     * son adresse mail, son profil, la ville de localisation et son secteur d'activité.
     *
     * @param mixed $var L'identifiant de l'entreprise à récupérer.
     * 
     * @return array|bool|object Les informations de l'entreprise sous forme d'un tableau ou un objet, ou `false` en cas d'erreur.
     */
    public function get($var)
    {
        // Prépare la requête SQL pour récupérer les informations d'une entreprise spécifique
        $sql = "SELECT t1.id_entreprise, t1.nom, t1.description, t1.mail, t1.chemin_profil_entreprise, t2.ville, t3.secteur 
                FROM entreprise t1
                JOIN localisation t2 ON t1.id_localisation = t2.id_localisation
                JOIN secteur t3 on t1.id_secteur  = t3.id_secteur
                WHERE id_entreprise = :var";

        // Connexion à la base de données
        $this->connect();

        // Préparation de la requête SQL
        $this->sth = $this->dbh->prepare($sql);

        // Exécution de la requête avec l'identifiant de l'entreprise
        $result = $this->execute(['var' => $var], false);

        // Fermeture de la connexion à la base de données
        $this->close();

        // Retourne les résultats de la requête ou un tableau vide si aucun résultat n'est trouvé
        return $result ?: []; // Renvoie un tableau vide en cas d'absence de données
    }


    /**
     * Récupère toutes les entreprises en fonction des filtres de recherche.
     *
     * Cette méthode permet de récupérer une liste d'entreprises en filtrant selon le nom de l'entreprise et le secteur,
     * en utilisant les paramètres de filtrage fournis.
     *
     * @param array $filters Les filtres de recherche (par exemple, 'search' pour le nom et 'secteur' pour le secteur).
     * 
     * @return array|bool|object La liste des entreprises correspondant aux critères de recherche ou un tableau vide si aucune correspondance.
     */
    public function getAll($filters)
    {
        // Prépare la requête SQL de base pour récupérer toutes les entreprises
        $sql = "SELECT t1.id_entreprise, t1.nom, t1.description, t1.mail, t1.chemin_profil_entreprise, t2.ville, t3.secteur 
                FROM entreprise t1
                JOIN localisation t2 ON t1.id_localisation = t2.id_localisation
                JOIN secteur t3 on t1.id_secteur  = t3.id_secteur
                WHERE 1=1"; // Condition '1=1' est utilisée pour ajouter dynamiquement des conditions supplémentaires

        // Tableau de paramètres pour les valeurs de la requête SQL
        $params = [];

        // Filtrage par nom de l'entreprise si le filtre 'search' est fourni
        if (!empty($filters['search'])) {
            $sql .= " AND t1.nom LIKE ?";  // Recherche du nom de l'entreprise
            $params[] = "%" . $filters['search'] . "%";  // Ajout du filtre de recherche
        }

        // Filtrage par secteur si le filtre 'secteur' est fourni
        if (!empty($filters['secteur'])) {
            $sql .= " AND t3.secteur = ?"; // Recherche du secteur spécifique
            $params[] = $filters['secteur']; // Ajout du filtre secteur
        }

        // Connexion à la base de données
        $this->connect();

        // Préparation de la requête SQL
        $this->sth = $this->dbh->prepare($sql);

        // Exécution de la requête avec les paramètres fournis
        $result = $this->execute($params, true);

        // Fermeture de la connexion à la base de données
        $this->close();

        // Retourne les résultats de la requête ou un tableau vide si aucun résultat n'est trouvé
        return $result ?: []; // Renvoie un tableau vide en cas d'absence de résultats
    }


    /**
     * Récupère la liste des entreprises avec leur ID et nom.
     *
     * Cette méthode permet de récupérer toutes les entreprises, mais seulement leurs ID et leurs noms, sans détails supplémentaires.
     *
     * @return array|bool|object La liste des entreprises avec leurs ID et noms ou un tableau vide si aucune entreprise n'est trouvée.
     */
    public function getAllName()
    {
        $sql = "SELECT id_entreprise, nom FROM entreprise";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(null, true);
        $this->close();
        return $result ?: [];
    }

}

?>