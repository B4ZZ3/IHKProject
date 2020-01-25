<?php
/**
 * Class to handle the Positions
 */
 mb_internal_encoding('utf-8');

 class Position {
    public $Id = null;
    public $Name = null;
    
    public function __construct( $data=array() ) {
        if ( isset( $data['Id'] ) ) $this->Id = (int) $data['Id'];
        if ( isset( $data['Name'] ) ) $this->Name = $data['Name'];
    }
    
    public function storeFormValues ( $params ) {
        $this->__construct( $params );
    }

    public static function getById( $Id ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM positions WHERE Id = :Id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":Id", $Id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) 
            return new Position( $row );
    }
    
    public static function getList() {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM positions ORDER BY Name ASC";

        $st = $conn->prepare( $sql );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $position = new Position( $row );
            $list[] = $position;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }
    
    public function insert() {
        if ( !is_null( $this->Id ) ) 
            trigger_error ( "Position::insert(): Versuch eine Position einzufügen, deren Id bereits gesetzt ist (Id: $this->Id).", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO positions (Name) VALUES (:Name)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->execute();
        $this->Id = $conn->lastInsertId();
        $conn = null;
        return $this->Id;
    }
    
    public function update() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Position::update(): Versuch eine Position zu aktualisieren, deren Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE positions SET Name=:Name WHERE Id = :Id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":Name", $this->Name, PDO::PARAM_STR );
        $st->bindValue( ":Id", $this->Id, PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
    
    public function delete() {
        if ( is_null( $this->Id ) ) 
            trigger_error ( "Position::delete(): Versuch eine Position zu löschen, deren Id noch nicht gesetzt ist.", E_USER_ERROR );

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM positions WHERE Id = :Id LIMIT 1" );
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