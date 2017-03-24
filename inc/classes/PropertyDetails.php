<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");

class PropertyDetails extends DatabaseItem {
    public $property_id, $pet_allow, $square_foot, $laundry, $heating_air, $garage, $school_district, $stories, $utility_include, $description;
    
    function __construct($databaseRowOrPropertyID = null) {
        if($databaseRowOrPropertyID) {
            if(is_array($databaseRowOrPropertyID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrPropertyID);                
            } else {
                $STH = self::$DBH -> prepare("CALL PropertyDetails_construct(:id)");
                $STH -> bindParam(":id", $databaseRowOrPropertyID);
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
            }
        }
        
    }
    
    function getShortDescription($stopanywhere = false) {
        $string = $this -> description;
        //truncates a string to a certain char length, stopping on a word if not specified otherwise.
        $length = 100;
        if (strlen($string) > $length) {
            //limit hit!
            $string = substr($string,0,($length -3));
            if ($stopanywhere) {
                //stop anywhere
                $string .= '...';
            } else{
                //stop on a word.
                $string = substr($string,0,strrpos($string,' ')).'...';
            }
        }
        return $string;
    }
    
    function setDataFromDatabaseRow($row) {
        $this -> property_id = $row['property_id'];
        $this -> pet_allow = $row['pet_allow'];
        $this -> square_foot = $row['square_foot'];
        $this -> laundry = $row['laundry'];
        $this -> heating_air = $row['heating_air'];
        $this -> garage = $row['garage'];
        $this -> school_district = $row['school_district'];
        $this -> stories = $row['stories'];
        $this -> utility_include = $row['utility_include'];
        $this -> description = $row['description'];
    }
    
    function insert($data, $propertyID)
    {
        $STH = self::$DBH -> prepare("Call sp_property_detail_INSERT     
        (                
          :Property_id, 
          :Pet_allow, 
          :Square_foot,
          :Laundry,
          :Heating_air,
          :Garage,
          :School_district, 
          :Stories,
          :Utility_include,
          :Description   
        )");
                $STH -> bindParam(":Property_id", $propertyID);
                $STH -> bindParam(":Pet_allow", $data['pet_allow']);
                $STH -> bindParam(":Square_foot", $data['square_foot']);
                $STH -> bindParam(":Laundry", $data['laundry']);
                $STH -> bindParam(":Heating_air", $data['heating_air']);
                $STH -> bindParam(":Garage", $data['garage']);
                $STH -> bindParam(":School_district", $data['school_district']);
                $STH -> bindParam(":Stories", $data['stories']);
                $STH -> bindParam(":Utility_include", $data['utility_include']);
                $STH -> bindParam(":Description", $data['description']);
                $STH -> execute();
        
        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
        
    }
    function delete($data)
    {
        $STH = self::$DBH -> prepare("CALL sp_property_detail_DELETE    
        (                
            :Property_id  
        )");
                $STH -> bindParam(":Property_id", $data['Property_id']);
                $STH -> execute();
    }
    function update($data) {
        $STH = self::$DBH -> prepare("CALL sp_property_detail_UPDATE     
        (                
          :Property_id, 
          :Pet_allow, 
          :Square_foot,
          :Laundry,
          :Heating_air,
          :Garage,
          :School_district, 
          :Stories,
          :Utility_include,
          :Description   
        )");
                $STH -> bindValue(":Property_id", $data['property_id'], PDO::PARAM_INT);
                $STH -> bindParam(":Pet_allow", $data['pet_allow']);
                $STH -> bindParam(":Square_foot", $data['square_foot']);
                $STH -> bindParam(":Laundry", $data['laundry']);
                $STH -> bindParam(":Heating_air", $data['heating_air']);
                $STH -> bindParam(":Garage", $data['garage']);
                $STH -> bindParam(":School_district", $data['school_district']);
                $STH -> bindParam(":Stories", $data['stories']);
                $STH -> bindParam(":Utility_include", $data['utility_include']);
                $STH -> bindParam(":Description", $data['description']);
                $STH -> execute();
    }
}
?>