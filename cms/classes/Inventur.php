<?php
class Inventur {
    private $conn;

    public $Id = null;
    public $Datum = null;
    public $Mitarbeiter = null;
    public $Finished = null;

    public function __construct($data=array()) {
        if(isset($data['Id'])) $this->Id = (int)$data['Id'];
        if(isset($data['Datum'])) $this->Datum = date_format(date_create($data['Datum']), "d/m/Y");
        if(isset($data['Mitarbeiter'])) $this->Mitarbeiter = preg_replace( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['Mitarbeiter'] );
        if(!empty($data['Finished'])) $this->Finished = (int)$data['Finished'];
    }

    public function createInventur($params) {
        $this->__construct($params);
    }

    public static function getAll() {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM inventur WHERE Finished = 1";
        $st = $conn->prepare($sql);
        $st->execute();
        $list = array();

        while($row = $st->fetch()) {
            $inventur = new Inventur( $row );
            $list[] = $inventur;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }
}
?>