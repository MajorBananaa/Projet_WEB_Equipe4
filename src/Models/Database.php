<?php 
namespace App\Controllers;

class Database {

    public $dbh = null;
    public $sth = null;

    public function __construct() {
        $this->dbh = null;
        $this->sth = null;
        
    }

    public function connect() {
        $this->dbh = new PDO('mysql:host=localhost;dbname=WS7', 'root');
    }

    public function close() {
        $this->dbh = null;
        $this->sth = null;
    }

    public function execute($sql) {
        $request = $dbh->prepare($sql);
        try {
            $request->execute();
            $result = $request->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e){
            return false;
        }
    }
}