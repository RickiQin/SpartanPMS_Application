<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

    require_once(__DIR__ . '/DatabaseItem.php');
    require_once(__DIR__ . "/GeocoderClass.php");
    
    class PropertyCoordinates extends DatabaseItem {
        public $propertyID, $latitude, $longitude, $lastUpdated;
        
        function __construct($propertyID) {
            if($propertyID) {
                $STH = self::$DBH -> prepare("CALL PropertyCoordinates_construct(:id)");
                $STH -> bindParam(":id", $propertyID);
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
                $STH -> closeCursor();
            }
            
            
        }
    
        function setDataFromDatabaseRow($row) {
            $this -> propertyID = $row['property_id'];
            $this -> latitude = $row['latitude'];
            $this -> longitude = $row['longitude'];
            $this -> lastUpdated = $row['lastUpdated'];
        }
        
        function upsert($propertyID, $lat, $lng) {
            $STH = self::$DBH -> prepare("CALL PropertyCoordinates_count(:propertyID)");
            $STH -> bindParam(":propertyID", $propertyID);
            $STH -> execute();
            $result = $STH -> fetch();
            $STH = null;
            if($result['found'] == 0) {
                $STH = self::$DBH -> prepare("CALL sp_property_coordinates_INSERT(:propertyID, :lat, :lng)");
            } else {
                $STH = self::$DBH -> prepare("CALL sp_property_coordinates_UPDATE(:propertyID, :lat, :lng)");
            }
            $STH -> bindParam(":propertyID", $propertyID);
            $STH -> bindParam(":lat", $lat);
            $STH -> bindParam(":lng", $lng);
            $STH -> execute();
        }
		
		function insert($data)
		{
			$STH = self::$DBH -> prepare("CALL sp_property_images_INSERT 
			( 
			  :Property_id,
			  :FullSizeImg,
			  :MedThumbnail,
			  :Thumbnail,
			  :IsDefault,
			  :Place
			  )");
			  
					$STH -> bindParam(":Property_id", $data['property_id']);
	                $STH -> bindParam(":FullSizeImg", $data['fullsizeimg']);
					$STH -> bindParam(":MedThumbnail", $data['medthumbnail']);
					$STH -> bindParam(":Thumbnail", $data['thumbnail']);
					$STH -> bindParam(":IsDefault", $data['isDefault']);
					$STH -> bindParam(":Place", $data['place']);
	                $STH -> execute();
	                
        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
		}
		
		function delete($data)
		{
			$STH = self::$DBH -> prepare("CALL sp_property_images_DELETE 
			( 
			  :Property_id 
			 )");
		          $STH -> bindParam(":Property_id", $data['property_id']);
	        	  $STH -> execute();
		}
		function update($data)
		{
			$STH = self::$DBH -> prepare("CALL sp_property_images_UPDATE
			( 
			  :Image_id,
			  :Property_id,
			  :FullSizeImg,
			  :MedThumbnail,
			  :Thumbnail,
			  :IsDefault,
			  :Place
			 )");
	                $STH -> bindParam(":Image_id", $data['image_id']);
					$STH -> bindParam(":Property_id", $data['property_id']);
					$STH -> bindParam(":MedThumbnail", $data['medthumbnail']);
					$STH -> bindParam(":Thumbnail", $data['thumbnail']);
					$STH -> bindParam(":IsDefault", $data['isdefault']);
					$STH -> bindParam(":Place", $data['place']);
	                $STH -> execute();
		}
}
?>