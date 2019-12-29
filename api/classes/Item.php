<?php
class Item {
    private $conn;
    private $table_name = "geraete";

    public $Inventarnummer = null;
    public $Name = null;
    public $BueroId = null;
    public $BueroName = null;
    public $InLager = null;

    public function __construct($db) {
        $this->conn = $db;
    }

    function getAll(){
        $query = "SELECT Inventarnummer, Name, BueroId, InLager FROM " . $this->table_name . " ORDER BY Inventarnummer DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }

    function getOne(){
        $query = "SELECT Inventarnummer, Name, BueroId, InLager FROM " . $this->table_name . " WHERE Inventarnummer = ? LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->Inventarnummer);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Inventarnummer = $row['Inventarnummer'];
        $this->Name = $row['Name'];
        $this->BueroId = $row['BueroId'];
        $this->InLager = $row['InLager'];
    }

    function update(){
        $query = "UPDATE " . $this->table_name . " SET BueroId = :BueroId WHERE Inventarnummer = :Inventarnummer";

        $stmt = $this->conn->prepare($query);
     
        $this->BueroId=htmlspecialchars(strip_tags($this->BueroId));
        $this->Inventarnummer=htmlspecialchars(strip_tags($this->Inventarnummer));
        $stmt->bindParam(':BueroId', $this->BueroId);
        $stmt->bindParam(':Inventarnummer', $this->Inventarnummer);

        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function getRemainingGeraete() {
        $query = "SELECT g.Name, b.Name FROM geraete AS g INNER JOIN buero AS b ON g.BueroId = b.Id WHERE b.Id NOT IN (SELECT GeraeteId FROM geraeteInventur)"; 

        $stmt = $this->conn->prepare($query);

        return $stmt;
    }
}
?>