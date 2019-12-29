<?php
class Inventur {
    private $conn;
    private $table_name = "inventur";

    public $Id = null;
    public $Datum = null;
    public $Mitarbeiter = null;
    public $Finished = null;

    public $GeraeteInv = null;
    public $BueroId = null;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUnfinished() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Finished = 0 LIMIT 1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Id = $row['Id'];
        $this->Datum = $row['Datum'];
        $this->Mitarbeiter = $row['Mitarbeiter'];
        $this->Finished = $row['Finished'];
    }

    function finish() {
        $query = "UPDATE " . $this->table_name . " SET Finished = 1 WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id=htmlspecialchars(strip_tags($this->Id));
        $stmt->bindParam(':Id', $this->Id);

        if($stmt->execute()){
            return true;
        }
     
        return false;
    } 

    function start() {
        $query = "INSERT INTO " . $this->table_name . " SET Datum = :Datum, Mitarbeiter = :Mitarbeiter, Finished = 0 ";

        $stmt = $this->conn->prepare($query);

        $this->Datum=htmlspecialchars(strip_tags($this->Datum));
        $this->Mitarbeiter=htmlspecialchars(strip_tags($this->Mitarbeiter));
        $stmt->bindParam(":Datum", $this->Datum);
        $stmt->bindParam(":Mitarbeiter", $this->Mitarbeiter);

        if($stmt->execute()){
            return true;
        }
     
        return false;    
    }

    function insertGeraete() {
        $query = "INSERT INTO geraeteInventur SET InventurId = :InventurId, GeraeteId = (SELECT Id FROM geraete WHERE Inventarnummer = :Inventarnummer) WHERE NOT EXISTS (SELECT * FROM geraeteInventur WHERE GeraeteId = (SELECT Id FROM geraete WHERE Inventarnummer = :Inventarnummer) )";
        $query2 = "UPDATE geraete SET BueroId = :BueroId WHERE Inventarnummer = :Inventarnummer";

        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        $this->Id=htmlspecialchars(strip_tags($this->Id));
        $this->GeraeteInv=htmlspecialchars(strip_tags($this->GeraeteInv));
        $stmt->bindParam(":InventurId", $this->Id);
        $stmt->bindParam(":Inventarnummer", $this->GeraeteInv);

        $this->BueroId=htmlspecialchars(strip_tags($this->BueroId));
        $stmt2->bindParam(":BueroId", $this->BueroId);
        $stmt2->bindParam(":Inventarnummer", $this->GeraeteInv);

        if($stmt->execute() && $stmt2->execute()){
            return true;
        }
     
        return false;    
    }
}
?>