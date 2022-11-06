<?php
/**
 * Class to handle the Category of the Items
 */

class Category extends Property {
    const TABLENAME = 'category';

    public static function getById( $Id ) {
        if(parent::getByTheId(self::TABLENAME, $Id))
            return new Category(parent::getByTheId(self::TABLENAME, $Id));
    }
    
    public static function getList() {
        $result = parent::getTheList(self::TABLENAME);
        $list = array();

        foreach($result as $row)
        {
            $producer = new Category( $row );
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