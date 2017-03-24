<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");


    class PropertyImage extends DatabaseItem {
		public $image_id, $property_id, $fullSizeImage,$thumbnail,$medThumbnail,$default,$order;
        function __construct($databaseRowOrImageID = null) {
            
            // SET DEFAULT
            $this -> fullSizeImage = "/image/detailpic.jpg";
            $this -> medThumbnail = "/image/detailpic.jpg";
            $this -> thumbnail = "/image/default_property_image.jpg";
           
            if($databaseRowOrImageID) {
                if(is_array($databaseRowOrImageID)) {
                    $this -> setDataFromDatabaseRow($databaseRowOrImageID);                
                } else {
                    $STH = self::$DBH -> prepare("CALL PropertyImage_construct(:id)");
                    $STH -> bindParam(":id", $databaseRowOrImageID);
                    $STH -> execute();
                    $this -> setDataFromDatabaseRow($STH -> fetch());
                }
            }       
        }
        
        function setDataFromDatabaseRow($row) {
            $this -> image_id = $row['image_id'];
            $this -> property_id = $row['property_id'];
            $this -> fullSizeImage = $row['fullSizeImg'];
            $this -> medThumbnail = $row['medThumbnail'];
            $this -> thumbnail = $row['thumbnail'];
            $this -> default = $row['isDefault'];
            $this -> order = $row['place'];
        }
        
        function getThumbnailHTML() {
            return '<a href="' . $this -> fullSizeImage . '"><img src="' . $this -> thumbnail . '" /></a>';
        }
        
        function getMedThumbnailHTML() {
            return '<a href="' . $this -> fullSizeImage . '"><img src="' . $this -> medThumbnail . '" /></a>';
        }
        
		function reorder($reorderParams)
		{
			
		}
		
		function upload($file)
		{
			
		}
		
		function replace($file)
		{
			
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
	                $STH -> bindParam(":FullSizeImg", $data['full_size_img']);
					$STH -> bindParam(":MedThumbnail", $data['med_thumbnail']);
					$STH -> bindParam(":Thumbnail", $data['thumbnail']);
	                $STH -> bindParam(":IsDefault", $data['is_default']);
					$STH -> bindParam(":Place", $data['place']);
	                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
		}
		
		function delete()
		{
		    if($this -> image_id > 0) {
    			$STH = self::$DBH -> prepare("CALL PropertyImage_delete(:id)");
    		    $STH -> bindParam(":id", $this -> image_id);
    	        $STH -> execute();
	        }
		}
        
        function makeDefault() {
            if($this -> image_id > 0 && $this -> property_id > 0) {
                $STH = self::$DBH -> prepare("CALL PropertyImage_makeDefault_1(:prop_id)");
                $STH -> bindParam(":prop_id", $this -> property_id);
                $STH -> execute();
                
                $STH = self::$DBH -> prepare("CALL PropertyImage_makeDefault_2(:img_id)");
                $STH -> bindParam(":img_id", $this -> image_id);
                $STH -> execute();
            }
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
					$STH -> bindParam(":FullSizeImg", $data['full_size_img']);
					$STH -> bindParam(":MedThumbnail", $data['med_thumbnail']);
					$STH -> bindParam(":Thumbnail", $data['thumbnail']);
					$STH -> bindParam(":IsDefault", $data['is_default']);
					$STH -> bindParam(":Place", $data['place']);
	                $STH -> execute();
		}
    }
?>