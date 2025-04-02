<?php

class Evaluation extends Database {
    public function add($data) {
        $sql = "INSERT INTO evaluation (id_eval, note, id_entreprise, id_utilisateur) 
            VALUES (?, ?, ?);";
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->sth->execute($data);
        $this->close();
        return $result ?:[];
    }
    
    public function remove($id) {
        $sql = "SELECT *
                FROM evaluation
                WHERE id_entreprise = :id";
         
        
        $this->connect();
        $this->sth = $this->dbh->prepare($sql);
        $result = $this->execute(['id' => $id], true);
        $this->close();
        
        return $result;
    
    }
    
    public function update($data) {}
    
    public function get($id) {}
    
    public function getAll() {}
}

?>