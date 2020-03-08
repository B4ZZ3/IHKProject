<?php
/**
 * Class to handle the CMS-Items
 */

 class Item {
    public $Id = null;
    public $Inventarnummer = null;
    public $Name = null;
    public $HerstellerId = null;
    public $KategorieId = null;
    public $PositionId = null;
    public $InLager = null;
    public $Schaden = null;

    public function __construct ($data=array()) {
        if(isset($data['Id'])) $this->Id = (int)$data['Id'];
        if(isset($data['Inventarnummer'])) $this->Inventarnummer = (int)$data['Inventarnummer'];
        if(isset($data['Name'])) $this->Name = $data['Name'];
        if(isset($data['HerstellerId'])) $this->HerstellerId = (int)$data['HerstellerId'];
        if(isset($data['KategorieId'])) $this->KategorieId = (int)$data['KategorieId'];
        if(isset($data['PositionId'])) $this->PositionId = (int)$data['PositionId'];
        if(!empty($data['InLager'])) $this->InLager = (int)$data['InLager'];
        if(!empty($data['Schaden'])) $this->Schaden = (int)$data['Schaden'];  
    }

    public function storeFormValues($params) {
        $this->__construct($params);
    }

    public static function getById($Id) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM item WHERE Id = :Id";
        $st = $conn->prepare($sql);
        $st->bindValue(":Id", $Id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if($row) 
            return new Item($row);
    }

    public static function getList($categoryId=null, $producerId=null, $positionId=null, $inStock=null, $damage=null) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $categoryClause = $categoryId ? "WHERE KategorieId = :KategorieId" : "";
        $producerClause = $producerId ? "WHERE HerstellerId = :HerstellerId" : "";
        $positionClause = $positionId ? "WHERE PositionId = :PositionId" : "";
        $inStockClause = $inStock ? "WHERE InLager = :InLager" : "";
        $damageClause = $damage ? "WHERE Schaden = :Schaden" : "";
        $sql = "SELECT * FROM item $categoryClause $producerClause $positionClause $inStockClause $damageClause ORDER BY Id ASC";

        $st = $conn->prepare( $sql );
        if ( $categoryId ) $st->bindValue( ":KategorieId", $categoryId, PDO::PARAM_INT );
        if ( $producerId ) $st->bindValue( ":HerstellerId", $producerId, PDO::PARAM_INT );
        if ( $positionId ) $st->bindValue( ":PositionId", $positionId, PDO::PARAM_INT );
        if ( $inStock ) $st->bindValue( ":InLager", $inStock, PDO::PARAM_INT );
        if ( $damage ) $st->bindValue( ":Schaden", $damage, PDO::PARAM_INT );
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
    
    public function insert() {
        if(!is_null($this->Id)) 
            trigger_error("Item::insert(): Versuch ein Item einzufügen, dessen Id bereits gesetzt ist (Id: $this->id).", E_USER_ERROR);

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO item (Inventarnummer, Name, HerstellerId, KategorieId, PositionId, InLager) VALUES (:Inventarnummer, :Name, :HerstellerId, :KategorieId, :PositionId, :InLager)";
        $st = $conn->prepare($sql);
        $st->bindValue(":Inventarnummer", $this->Inventarnummer, PDO::PARAM_INT);
        $st->bindValue(":Name", $this->Name, PDO::PARAM_STR);
        $st->bindValue(":HerstellerId", $this->HerstellerId, PDO::PARAM_INT);
        $st->bindValue(":KategorieId", $this->KategorieId, PDO::PARAM_INT);
        $st->bindValue(":PositionId", $this->PositionId, PDO::PARAM_INT);
        $st->bindValue(":InLager", $this->InLager, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {
        if(is_null($this->Id)) 
            trigger_error("Item::update(): Versuch ein Item zu aktualisieren, dessen Id noch nicht gestzt ist.", E_USER_ERROR);
    
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE item SET Inventarnummer = :Inventarnummer, Name = :Name, HerstellerId = :HerstellerId, KategorieId = :KategorieId, PositionId = :PositionId, InLager = :InLager WHERE Id = :Id";
        $st = $conn->prepare($sql);
        $st->bindValue(":Inventarnummer", $this->Inventarnummer, PDO::PARAM_INT);
        $st->bindValue(":Name", $this->Name, PDO::PARAM_STR);
        $st->bindValue(":HerstellerId", $this->HerstellerId, PDO::PARAM_INT);
        $st->bindValue(":KategorieId", $this->KategorieId, PDO::PARAM_INT);
        $st->bindValue(":PositionId", $this->PositionId, PDO::PARAM_INT);
        $st->bindValue(":InLager", $this->InLager, PDO::PARAM_INT);
        $st->bindValue(":Id", $this->Id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {
        if(is_null($this->Id)) trigger_error("Item::delete(): Versuch ein Item zu löschen, dessen Id noch nicht gesetzt ist.", E_USER_ERROR);

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "DELETE FROM item WHERE Id = :Id LIMIT 1";
        $st = $conn->prepare($sql);
        $st->bindValue(":Id", $this->Id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function generateQRCode() {
        $fileName = 'geraet_InvNr_'.$this->Inventarnummer.'.png';
        $pngAbsoluteFilePath = QRCODE_PATH_GERAETE.$fileName;

        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png('Inventarnummer='.$this->Inventarnummer, $pngAbsoluteFilePath);
        }
    }
}
?>