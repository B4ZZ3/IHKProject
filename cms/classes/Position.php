<?php
/**
 * Class to handle the Positions of the Items in the building
 */

class Position extends Property {
    const TABLENAME = 'positions';

    public static function getById( $Id ) {
        if(parent::getByTheId(self::TABLENAME, $Id))
            return new Position(parent::getByTheId(self::TABLENAME, $Id));
    }
    
    public static function getList() {
        $result = parent::getTheList(self::TABLENAME);
        $list = array();

        foreach($result as $row)
        {
            $producer = new Position( $row );
            $list[] = $producer;
        }
        return ( array ( "results" => $list ) );
    }
    
    public function insert() {
        parent::insertInto(self::TABLENAME);
    }
    
    public function update() {
        parent::updateInto(self::TABLENAME);
    }
    
    public function delete() {
        parent::deleteInto(self::TABLENAME);
    }

    public function generateQRCode() {
        $fileName = 'buero_Id_'.$this->Id.'.png';
        $pngAbsoluteFilePath = QRCODE_PATH_BUERO.$fileName;

        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png('BueroId='.$this->Id, $pngAbsoluteFilePath);
        }
    }
}
?>