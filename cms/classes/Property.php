<?php
/**
 * Class to handle inheritance
 */

class Property {
    public $Id = null;
    public $Name = null;
    
    public function __construct( $data=array() ) {
        if ( isset( $data['Id'] ) ) $this->Id = (int) $data['Id'];
        if ( isset( $data['Name'] ) ) $this->Name = $data['Name'];
    }
    
    public function storeFormValues ( $params ) {
        $this->__construct( $params );
    }

    public static function getByTheId( $table, $Id ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM $table WHERE Id = :Id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ':Id', $Id, PDO::PARAM_INT );
        $st->execute();
        return $st->fetch();
        $conn = null;
        // if ( $row ) 
        //     return new Producer( $row );
    }
    
    public static function getTheList($table) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM $table ORDER BY Name ASC";
        $st = $conn->prepare( $sql );
        $st->execute();
        return $st->fetchAll();
        // $list = array();

        // return $row = $st->fetch();
        $conn = null;
    }
    
    public function insertInto($table) {
        if ( !is_null( $this->Id ) ) 
            trigger_error ( "Insert(): Versuch einzufügen wo die Id bereits gesetzt ist (Id: $this->Id).", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO $table (Name) VALUES (:Name)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->execute();
        $this->Id = $conn->lastInsertId();
        $conn = null;
    }
    
    public function updateInto($table) {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Update(): Versuch zu aktualisieren wo die Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE $table SET Name=:Name WHERE Id = :Id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
    
    public function deleteInto($table) {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Delete(): Versuch zu löschen wo die Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM $table WHERE Id = :Id LIMIT 1" );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
}
?>