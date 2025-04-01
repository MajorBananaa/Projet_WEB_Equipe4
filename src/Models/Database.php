<?php 
namespace App\Models;
use PDO;
use PDOException;
class Database {

    public $dbh = null;
    public $sth = null;

    public function __construct() {
        $this->dbh = $this->connect();
        $this->sth = null;
        
    }

    public function connect() {
        try{
            $this->dbh = new PDO('mysql:host=localhost;dbname=projet_web_equipe4', 'root');
            echo "connection réussi ! :) ";
            return $this->dbh;
        }catch (PDOException $e) {
            echo "connexion failed";
            return false;
        }

    }

    public function close() {
        $this->dbh = null;
        $this->sth = null;
    }

    public function execute($sql, $params = []) {
        try {
            $request = $this->dbh->prepare($sql);
            $request->execute($params);
            return $request->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
}