<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");
require_once(__DIR__ . "/GeocoderClass.php");
require_once(__DIR__ . "/PropertyCoordinates.php");
require_once(__DIR__ . "/PropertyImage.php");
require_once(__DIR__ . "/SavedProperty.php");
require_once(__DIR__ . "/FeaturedProperty.php");
require_once(__DIR__ . "/PropertyDetails.php");

class Property extends DatabaseItem {
    public $id, $property_type, $address, $city, $state, $zip, $bedrooms, $bathrooms, $rent, $available, $dateCreated, $coordinates, $details;
    
    function __construct($databaseRowOrID = null) {
        parent::__construct();
        if($databaseRowOrID) {
            if(is_array($databaseRowOrID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrID);                
            } else {
                $STH = self::$DBH -> prepare("CALL property_select_by_id(:id)");
                $STH -> bindParam(":id", $databaseRowOrID);
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
                $STH -> closeCursor();
            }
        }
        
        if($this -> id > 0) {
            $this -> coordinates = new PropertyCoordinates($this -> id);
            if(!is_numeric($this -> coordinates -> latitude) || !is_numeric($this -> coordinates -> longitude)) {
                $this -> updateGeocode();
            }
            
            $this -> details = new PropertyDetails($this -> id);
        }
    }
    
    function setDataFromDatabaseRow($row) {
        $this -> id = $row['property_id'];
        $this -> property_type = $row['property_type'];
        $this -> address = $row['address'];
        $this -> city = $row['city'];
        $this -> state = $row['state'];
        $this -> zip = $row['zip'];
        $this -> bedrooms = $row['bedrooms'];
        $this -> bathrooms = $row['bathrooms'];
        $this -> rent = $row['rent'];
        $this -> available = $row['available'];
        $this -> dateCreate = $row['dateCreated'];
    }
    
    function updateGeocode() {
        $stringToGeocode = $this -> address . ", " . $this -> city . ", " . $this -> state . " " . $this -> zip;
        $response = Geocoder::geocode($stringToGeocode);
        
        if(is_array($response)) {
            $lat = $response['latitude'];
            $lng = $response['longitude'];
            $this -> coordinates -> upsert($this -> id, $lat, $lng);
        }
        
    }
    
    function getDefaultImage() {
        $STH = self::$DBH -> prepare("CALL property_select_propertyimage(:prop_id)");
        $STH -> bindParam(":prop_id", $this -> id);
        $STH -> execute();
        $row = $STH ->fetch();   
        $STH -> closeCursor();
        if(!is_array($row)) {
            // if no default, check to see if other images exist and use one of those
            $STH = self::$DBH -> prepare("CALL property_select_property_image_by_id(:prop_id)");
            $STH -> bindParam(":prop_id", $this -> id);
            $STH -> execute();
            $row = $STH -> fetch();
            $STH -> closeCursor();
        }
        if(is_array($row)) {
            return new PropertyImage($row, self::$DBH);
        }
           
        return new PropertyImage(null);
    }
    
    static function getAll() {
        $STH = self::$DBH -> prepare("CALL property_select_property_by_address");
        $STH -> execute();
        
        $properties = array();
        $rows = $STH -> fetchAll();
        $STH -> closeCursor();
        foreach($rows as $row) {
            $properties[] = new Property($row);
        }
        
        return $properties;
    }
    
    function getThumbnails() {
        $STH = self::$DBH -> prepare("CALL property_select_propertyimage_by_propid_default0(:prop_id)");
        $STH -> bindParam(":prop_id", $this -> id);
        $STH -> execute();
        $rows = $STH -> fetchAll();
        $STH -> closeCursor();
        $thumbnails = array();
        foreach($rows as $row) {
            $thumbnails[] = new PropertyImage($row);
        }
        
        return $thumbnails;
    }
	
    function feature() {
        $featuredProperty = new FeaturedProperty();
        $featuredProperty -> insert($this -> id);
    }
    
    function save() {
        $savedProperty = new SavedProperty();
        $savedProperty -> insert($this -> id);
    }
    
	function insert($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_properties_INSERT     
		(                
			:Property_type,
		    :Address,
		    :City,
		    :State,  
		    :Zip,
		    :Bedrooms,
		    :Bathrooms,
		    :Rent    
		)");
		  
				$STH -> bindParam(":Property_type", $data['type']);
                $STH -> bindParam(":Address", $data['address']);
				$STH -> bindParam(":City", $data['city']);
                $STH -> bindParam(":State", $data['state']);
				$STH -> bindParam(":Zip", $data['zip']);
                $STH -> bindParam(":Bedrooms", $data['bedrooms']);
				$STH -> bindParam(":Bathrooms", $data['bathrooms']);
				$STH -> bindParam(":Rent", $data['rent']);
                $STH -> execute();
                
        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
	}
	
	function delete($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_properties_DELETE    
		(                
			:Property_id  
		)");
	          $STH -> bindParam(":Property_id", $data['Property_id']);
        	  $STH -> execute();
	}
    
	function update($data)
	{
        
		$STH = self::$DBH -> prepare("CALL sp_properties_UPDATE    
		(       
			:Property_id,
			:Property_type,
		    :Address,
		    :City,
		    :State,  
		    :Zip,
		    :Bedrooms,
		    :Bathrooms,
		    :Rent    
		)");
		
        $STH -> bindValue(":Property_id", $data['property_id'], PDO::PARAM_INT);
		$STH -> bindParam(":Property_type", $data['type']);
		$STH -> bindParam(":Address", $data['address']);
		$STH -> bindParam(":City", $data['city']);
		$STH -> bindParam(":State", $data['state']);
		$STH -> bindParam(":Zip", $data['zip']);
		$STH -> bindParam(":Bedrooms", $data['bedrooms']);
		$STH -> bindParam(":Bathrooms", $data['bathrooms']);
		$STH -> bindParam(":Rent", $data['rent']);
        $STH -> execute();
	}
    
        static function validate($post) {
        
        if(isset($post['property_id'])) {
            if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['property_id'])) {
                return false;
            }
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['type'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['address'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['city'])) {
            return false;
        }   
        
        if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['state'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['zip'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_INT, $post['bedrooms'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_INT, $post['bathrooms'])) {
            return false;
        }

       if(!is_numeric($post['rent']) || $post['rent'] < 0) {
           return false;
       }
        
       return true;
    }
}

?>