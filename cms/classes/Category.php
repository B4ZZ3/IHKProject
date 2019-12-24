<?php
/**
 * Class to handle the Item-Categories
 */

 class Category {
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
        $sql = "SELECT * FROM kategorie WHERE Id = :Id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":Id", $Id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) 
            return new Category( $row );
    }
    
    public static function getList() {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM kategorie ORDER BY Name ASC";

        $st = $conn->prepare( $sql );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $category = new Category( $row );
            $list[] = $category;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }
    
    public function insert() {
        if ( !is_null( $this->Id ) ) 
            trigger_error ( "Kategorie::insert(): Versuch eine Kategorie einzufügen, deren Id bereits gesetzt ist (Id: $this->Id).", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO kategorie (Name) VALUES (:Name)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }
    
    public function update() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Kategorie::update(): Versuch eine Kategorie zu aktualisieren, deren Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE kategorie SET Name=:Name WHERE Id = :Id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        console_log($st);
        $st->execute();
        $conn = null;
    }
    
    public function delete() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Kategorie::delete(): Versuch eine Kategorie zu löschen, deren Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM kategorie WHERE Id = :Id LIMIT 1" );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
}
?>