<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");

class SavedProperty extends DatabaseItem {
	public $dateSaved, $propertyID, $id;
	
	function __construct($databaseRowOrPropertyID = null) {
        parent::__construct();
        if($databaseRowOrPropertyID) {
            if(is_array($databaseRowOrID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrPropertyID);                
            } else {
                $STH = self::$DBH -> prepare("CALL SavedProperty_construct(:id, :user_id)");
                $STH -> bindParam(":id", $databaseRowOrPropertyID);
                $STH -> bindParam(":user_id", Authentication::getUserID());
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
            }
        }
    }
	
	function setDataFromDatabaseRow($row) {
	    if(is_array($row)) {
            $this -> id = $row['usp_id'];
            $this -> propertyID = $row['property_id'];
            $this -> dateSaved = $row['dateSaved'];
        }
    }
	
	function insert($propertyID)
	{
		$STH = self::$DBH -> prepare("CALL sp_user_saved_properties_INSERT
		( 
		  :Property_ID,
		  :User_id 
		)");
                $STH -> bindParam(":Property_ID", $propertyID);
				$STH -> bindParam(":User_id", Authentication::getUserID());
                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
	}
	
	function delete()
	{
		$STH = self::$DBH -> prepare("CALL sp_user_saved_properties_DELETE
		( 
		  :Usp_id
		)");
                $STH -> bindParam(":Usp_id", $this -> id);
                $STH -> execute();
	}
	function update($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_user_saved_properties_UPDATE
		( 
		  :Usp_id,
		  :Property_id,
		  :User_id 
		)");
                $STH -> bindParam(":Usp_id", $data['Usp_id']);
				$STH -> bindParam(":Property_id", $data['Property_id']);
				$STH -> bindParam(":User_id", $data['User_id']);
                $STH -> execute();
	}
	
}

?>