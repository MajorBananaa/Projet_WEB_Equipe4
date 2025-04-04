<?php
namespace App\Models;
use App\Models\Database;

class Candidature extends Database
{
    /**
     * Ajoute une nouvelle candidature dans la base de données.
     *
     * Cette méthode permet d'insérer une nouvelle candidature dans la table `candidature`. 
     * Les informations nécessaires pour la candidature incluent l'ID de l'offre, l'ID de l'utilisateur, 
     * le chemin du fichier CV et la lettre de motivation.
     *
     * La méthode prépare et exécute une requête SQL pour insérer les données de la candidature dans la base.
     * La date de la candidature est automatiquement ajoutée en utilisant la fonction `CURDATE()` de MySQL.
     *
     * @param array $data Un tableau contenant les informations à insérer :
     *                    [0] => id_offres (ID de l'offre),
     *                    [1] => id_utilisateur (ID de l'utilisateur),
     *                    [2] => chemin_cv (Chemin vers le fichier CV),
     *                    [3] => lettre_motivation (Lettre de motivation)
     * 
     * @return mixed Retourne le résultat de l'exécution de la requête SQL (`true` ou `false`) 
     *               ou un tableau vide (`[]`) si l'exécution échoue ou en cas de problème.
     */
    public function add($data)
    {
        $sql = "INSERT INTO candidature (id_offres, id_utilisateur, date_candidature, chemin_cv, lettre_motivation) 
                VALUES (?, ?, CURDATE(), ?, ?);";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->sth->execute($data);
        $this->close();
        return $result ?: [];
    }


    public function remove($id)
    {
    }

    public function update($data)
    {
    }

    /**
     * Récupère les informations des candidatures en fonction du rôle de l'utilisateur.
     *
     * Cette méthode récupère les candidatures pour un utilisateur donné, en fonction de son rôle. 
     * Si le rôle de l'utilisateur est "étudiant" (idRole == 3), elle retourne toutes les candidatures 
     * de cet utilisateur. Si le rôle est "entreprise" (idRole == 2), elle retourne les candidatures 
     * des utilisateurs faisant partie de la même promotion.
     *
     * @param int $idUtilisateur L'ID de l'utilisateur pour lequel on récupère les candidatures.
     * @param int $idRole Le rôle de l'utilisateur (1 pour admin, 2 pour entreprise, 3 pour étudiant).
     *
     * @return array|bool|object Retourne :
     * - Un tableau associatif des candidatures si la requête réussit, 
     * - `false` si aucune candidature n'est trouvée, 
     * - Un objet ou un tableau selon le résultat de l'exécution de la requête.
     */
    public function get($idUtilisateur, $idRole)
    {
        $sql = "SELECT t1.id_postuler, t1.date_candidature,
                    t2.titre AS offre_titre, t3.nom AS utilisateur_nom
                FROM candidature t1
                JOIN offre t2 ON t1.id_offres = t2.id_offres
                JOIN utilisateur t3 ON t1.id_utilisateur = t3.id_utilisateur";
        $params = [];

        // Cas où l'utilisateur est un étudiant (récupère ses propres candidatures)
        if ($idRole == 3) {
            $sql .= " WHERE t1.id_utilisateur = ?";
            $params[] = $idUtilisateur;
        }
        // Cas où l'utilisateur est une entreprise (récupère les candidatures des étudiants de la même promotion)
        elseif ($idRole == 2) {
            $sql_promotion = "SELECT t3.id_promotion 
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


    /**
     * Récupère le nombre de candidatures pour une offre donnée.
     *
     * Cette méthode effectue une requête SQL pour obtenir le nombre de candidatures associées à une offre spécifique.
     * La requête retourne le nombre de candidatures (`nbCandidats`) pour l'ID de l'offre passé en paramètre.
     *
     * @param int $id L'ID de l'offre pour laquelle nous comptons les candidatures.
     *
     * @return array|bool|object Retourne :
     * - Un tableau contenant le nombre de candidatures sous forme associative (clé `nbCandidats`).
     * - `false` en cas d'échec de l'exécution de la requête.
     * - Un objet PDOStatement, selon l'implémentation de la méthode `execute`, si la requête est correctement préparée mais non exécutée.
     */
    public function getOffre($id)
    {
        $sql = "SELECT COUNT(*) AS nbCandidats 
                FROM candidature
                WHERE id_offres = :id";

        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id], false);
        $this->close();

        return $result;
    }



    /**
     * Récupère toutes les candidatures enregistrées, ainsi que les informations associées sur les offres et les utilisateurs.
     *
     * Cette méthode effectue une requête SQL pour récupérer les informations suivantes pour chaque candidature :
     * - `id_postuler`: L'ID de la candidature.
     * - `date_candidature`: La date de la candidature.
     * - `chemin_cv`: Le chemin du fichier du CV.
     * - `lettre_motivation`: La lettre de motivation de l'utilisateur.
     * - `offre_titre`: Le titre de l'offre pour laquelle la candidature a été soumise.
     * - `utilisateur_nom`: Le nom de l'utilisateur ayant postulé.
     *
     * Les données sont récupérées en effectuant une jointure entre les tables `candidature`, `offre`, et `utilisateur`.
     *
     * @return array|bool|object Retourne soit :
     * - Un tableau contenant les candidatures, ou un tableau vide si aucune candidature n'est trouvée.
     * - `false` en cas d'échec d'exécution de la requête.
     * - Un objet PDOStatement en cas de succès de la préparation de la requête, selon l'implémentation de la méthode `execute`.
     */
    public function getAll()
    {
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