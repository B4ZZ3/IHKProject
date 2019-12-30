<?php
/**
 * Class to handle the Offices
 */

 class Office {
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
        $sql = "SELECT * FROM buero WHERE Id = :Id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":Id", $Id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) 
            return new Office( $row );
    }
    
    public static function getList() {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM buero ORDER BY Name ASC";

        $st = $conn->prepare( $sql );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $office = new Office( $row );
            $list[] = $office;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }
    
    public function insert() {
        if ( !is_null( $this->Id ) ) 
            trigger_error ( "Büro::insert(): Versuch ein Büro einzufügen, dessen Id bereits gesetzt ist (Id: $this->Id).", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO buero (Name) VALUES (:Name)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->execute();
        $this->Id = $conn->lastInsertId();
        $conn = null;
        return $this->Id;
    }
    
    public function update() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Büro::update(): Versuch ein Büro zu aktualisieren, dessen Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE buero SET Name=:Name WHERE Id = :Id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
    
    public function delete() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Büro::delete(): Versuch ein Büro zu löschen, dessen Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM buero WHERE Id = :Id LIMIT 1" );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }

    public function generateQRCode($InsertId) {
        console_log($InsertId);
        $fileName = 'buero_Id_'.$InsertId.'.png';
        $pngAbsoluteFilePath = QRCODE_PATH_BUERO.$fileName;

        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png('BueroId='.$this->Id, $pngAbsoluteFilePath);
        }
    }
}
?>