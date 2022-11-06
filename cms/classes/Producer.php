<?php
/**
 * Class to handle the Producer of the Items
 */

class Producer extends Property {
    const TABLENAME = 'producer';

    public static function getById( $Id ) {
        if(parent::getByTheId(self::TABLENAME, $Id))
            return new Producer(parent::getByTheId(self::TABLENAME, $Id));
    }
    
    public static function getList() {
        $result = parent::getTheList(self::TABLENAME);
        $list = array();

        foreach($result as $row)
        {
            $producer = new Producer( $row );
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
}
?>