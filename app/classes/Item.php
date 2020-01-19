<?php
class Item {
    private $conn;

    public $Inventarnummer = null;
    public $Name = null;
    public $BueroId = null;
    public $BueroName = null;
    public $InLager = null;

    public function __construct($data=array()) {
        if(isset($data['Inventarnummer'])) $this->Inventarnummer = (int)$data['Inventarnummer'];
        if(isset($data['Name'])) $this->Name = preg_replace( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['Name'] );
        if(isset($data['BueroId'])) $this->BueroId = (int)$data['BueroId'];
        if(isset($data['BueroName'])) $this->BueroName = preg_replace( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['BueroName'] );
        if(!empty($data['InLager'])) $this->InLager = (int)$data['InLager'];
    }

    function getRemainingGeraete() {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT g.Name, g.InLager, b.Name AS BueroName FROM geraete AS g INNER JOIN buero AS b ON g.BueroId = b.Id WHERE g.Id NOT IN (SELECT GeraeteId FROM geraeteInventur) ORDER BY g.Id ASC"; 
        $st = $conn->prepare( $sql );
        $st->execute();
        $list = array();

        while($row = $st->fetch()) {
            $item = new Item( $row );
            $list[] = $item;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }
}
?>