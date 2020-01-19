<?php
class Inventur {
    private $conn;

    public $Id = null;
    public $Datum = null;
    public $Mitarbeiter = null;
    public $Finished = null;

    public $GeraeteInv = null;
    public $BueroId = null;

    public function __construct($data=array()) {
        if(isset($data['Id'])) $this->Id = (int)$data['Id'];
        if(isset($data['Datum'])) $this->Datum = date_format(date_create($data['Datum']), "d/m/Y");
        if(isset($data['Mitarbeiter'])) $this->Mitarbeiter = preg_replace( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['Mitarbeiter'] );
        if(!empty($data['Finished'])) $this->Finished = (int)$data['Finished'];
    }

    public function createInventur($params) {
        $this->__construct($params);
    }

    public static function getUnfinished() {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM inventur WHERE Finished = 0 LIMIT 1";
        $st = $conn->prepare($sql);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if($row) 
            return new Inventur($row);
    }

    function finish() {
        if(is_null($this->Id)) 
            trigger_error("Inventur::finish(): Versuch eine Inventur zu beenden, deren Id noch nicht gesetzt ist.", E_USER_ERROR);
    
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE inventur SET Finished = 1 WHERE Id = :Id";
        $st = $conn->prepare($sql);
        $st->bindValue(":Id", $this->Id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    } 

    function start() {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO inventur SET Mitarbeiter = :Mitarbeiter";
        $st = $conn->prepare($sql);
        $st->bindValue(":Mitarbeiter", $this->Mitarbeiter, PDO::PARAM_STR);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;   
    }

    function insertGeraete() {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO geraeteinventur (InventurId, GeraeteId) VALUES(:InventurId, (SELECT Id FROM geraete WHERE Inventarnummer = :Inventarnummer))";
        $sql2 = "UPDATE geraete SET BueroId = :BueroId WHERE Inventarnummer = :Inventarnummer";

        $st = $conn->prepare($sql);
        $st2 = $conn->prepare($sql2);

        $st->bindValue(":InventurId", $this->Id, PDO::PARAM_INT);
        $st->bindValue(":Inventarnummer", $this->GeraeteInv, PDO::PARAM_INT);

        $st2->bindValue(":BueroId", $this->BueroId, PDO::PARAM_INT);
        $st2->bindValue(":Inventarnummer", $this->GeraeteInv, PDO::PARAM_INT);
        
        $st->execute();
        $st2->execute();
        $conn = null;
    }
}
?>