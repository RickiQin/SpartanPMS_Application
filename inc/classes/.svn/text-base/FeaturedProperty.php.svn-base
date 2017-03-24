<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");
require_once(__DIR__ . "/Property.php");

class FeaturedProperty extends DatabaseItem {
    public $id, $dateSaved, $propertyID;
    
    function __construct($databaseRowOrPropertyID = null) {
        parent::__construct();
        if($databaseRowOrPropertyID) {
            if(is_array($databaseRowOrID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrPropertyID);                
            } else {
                $STH = self::$DBH -> prepare("CALL featuredproperty_select_featured_property_by_id(:id)");
                $STH -> bindParam(":id", $databaseRowOrPropertyID);
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
            }
        }
    }
    
    function setDataFromDatabaseRow($row) {
        if(is_array($row)) {
            $this -> id = $row['fp_id'];
            $this -> propertyID = $row['property_id'];
            $this -> dateSaved = $row['dateSaved'];
        }
    }
    
    function getAll() {
        $STH = self::$DBH -> query("CALL featuredproperty_select_oderbydate");
        $featuredProperties = $STH -> fetchAll();
        $STH -> closeCursor();
        $properties = array();
        foreach($featuredProperties as $featuredProperty) {
            $properties[] = new Property($featuredProperty['property_id']);
        }
        return $properties;
    }
    
    function insert($propertyID)
    {
        $STH = self::$DBH -> prepare("CALL sp_properties_featured_INSERT
        ( 
          :Property_ID
        )");
                $STH -> bindParam(":Property_ID", $propertyID);
                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
    }
    
    function delete()
    {
        $STH = self::$DBH -> prepare("CALL sp_properties_featured_DELETE
        ( 
          :fp_id
        )");
                $STH -> bindParam(":fp_id", $this -> id);
                $STH -> execute();
    } 
}

?>