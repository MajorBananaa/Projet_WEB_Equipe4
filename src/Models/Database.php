<?php 
namespace App\Models;
use PDO;
use PDOException;

class Database {

    public $dbh = null;
    public $sth = null;

    /**
     * Établit une connexion à la base de données.
     *
     * @return void
     */
    public function connect() {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=Projet_WEB_Equipe4', 'root', '');
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
    * Ferme la connexion à la base de données.
    *
    * @return void
    */
    public function close() {
        $this->dbh = null;
        $this->sth = null;
    }

    /**
     * Exécute une requête SQL et retourne le résultat.
     *
     * @param string $sql La requête SQL à exécuter.
     * @param bool $fetchall Indique si tous les résultats doivent être retournés (true) ou un seul (false).
     * @return object|array|false Retourne un objet, un tableau d'objets ou false en cas d'erreur.
     */
    public function execute($fetchall) {
        try {
            $this->sth->execute();
            if ($fetchall) {
                return $this->sth->fetchall(PDO::FETCH_OBJ);
            } else {
                return $this->sth->fetch(PDO::FETCH_OBJ);
            }
            
        } catch (PDOException $e) {
            return false;
        }
    }
}