<?php
/**
 * Class to handle the Item-Producer
 */

 class Producer {
    public $Id = null;
    public $Name = null;
    
    public function __construct( $data=array() ) {
        if ( isset( $data['Id'] ) ) $this->Id = (int) $data['Id'];
        if ( isset( $data['Name'] ) ) $this->Name = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['Name'] );
    }
    
    public function storeFormValues ( $params ) {
        $this->__construct( $params );
    }

    public static function getById( $Id ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM hersteller WHERE Id = :Id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":Id", $Id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) 
            return new Producer( $row );
    }
    
    public static function getList() {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM hersteller ORDER BY Name ASC";

        $st = $conn->prepare( $sql );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $producer = new Producer( $row );
            $list[] = $producer;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }
    
    public function insert() {
        if ( !is_null( $this->Id ) ) 
            trigger_error ( "Hersteller::insert(): Versuch einen Hersteller einzufügen, dessen Id bereits gesetzt ist (Id: $this->Id).", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO hersteller (Name) VALUES (:Name)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }
    
    public function update() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Hersteller::update(): Versuch einen Hersteller zu aktualisieren, dessen Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE hersteller SET Name=:Name WHERE Id = :Id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
    
    public function delete() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Hersteller::delete(): Versuch einen Hersteller zu löschen, dessen Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM hersteller WHERE Id = :Id LIMIT 1" );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
}
?>