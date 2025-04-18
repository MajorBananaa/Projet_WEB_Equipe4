<?php
namespace App\Models;
use PDO;
use PDOException;

class Database
{

    public $dbh = null;
    public $sth = null;

    /**
     * Établit une connexion à la base de données.
     *
     * @return void
     */
    public function connect()
    {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=Projet_WEB_Equipe4', 'root', '');
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * Ferme la connexion à la base de données.
     *
     * @return void
     */
    public function close()
    {
        $this->dbh = null;
        $this->sth = null;
    }

    /**
     * Exécute une requête SQL avec des paramètres et retourne le résultat.
     *
     * @param array|null $para Tableau des paramètres à lier à la requête, ou null si aucun.
     * @param bool $fetchall Indique si tous les résultats doivent être retournés (true) ou un seul (false) ou si (null) alors il ne revoit rien.
     * @return object|array|false Retourne un objet, un tableau d'objets ou false en cas d'erreur.
     */
    public function execute($para, $fetchall = null)
    {
        try {
            $this->sth->execute($para);
            if ($fetchall) {
                return $this->sth->fetchAll(PDO::FETCH_OBJ);
            } elseif (!$fetchall) {
                return $this->sth->fetch(PDO::FETCH_OBJ);
            } else {
                return true;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}