<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");
require_once(__DIR__ . "/Property.php");
require_once (__DIR__ . "/User.php");

class PropertyLease extends DatabaseItem {	
    public $id, $property,$user,$signedBy,$leaseStartDate,$leaseEndDate,$rent,$lastUpdated;
	
    function __construct($databaseRowOrID = null) {
        if(is_array($databaseRowOrID)) {
            $this -> setDataFromDatabaseRow($databaseRowOrID);                
        } else {
            $STH = self::$DBH -> prepare("CALL PropertyLease_construct(:id)");
            $STH -> bindParam(":id", $databaseRowOrID);
            $STH -> execute();
            $row = $STH -> fetch();
            $STH -> closeCursor();
            $this -> setDataFromDatabaseRow($row);
            $STH -> closeCursor();
        }
    }
    	
    function setDataFromDatabaseRow($row) {
        $this -> id = $row['lease_id'];
        $this -> property = new Property($row['property_id']);
        $this -> user = new User($row['user_id']);
        $this -> signedBy = new User($row['signedBy_agent']);
        $this -> leaseStartDate = $row['leaseStartDate'];
        $this -> leaseEndDate = $row['leaseEndDate'];
        $this -> rent = $row['rent'];
        $this -> lastUpdated = $row['lastUpdated'];
    }
    
    static function getAll() {
        $STH = self::$DBH -> prepare("CALL PropertyLease_getAll");
        $STH -> execute();
        
        $leases = array();
        $rows = $STH -> fetchAll();
        $STH -> closeCursor();
        foreach($rows as $row) {
            $leases[] = new PropertyLease($row);
        }
        
        return $leases;
    }
	
	function insert($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_property_leases_INSERT
		(  
		  :Property_id,
		  :User_id,
		  :LeaseStartDate,
		  :LeaseEndDate,
		  :Rent,
		  :SignedBy_agent  
		)");
		  
				$STH -> bindParam(":Property_id", $data['property_id']);
                $STH -> bindParam(":User_id", $data['user_id']);
				$STH -> bindParam(":LeaseStartDate", date("Y-m-d", strtotime($data['lease_start_date'])));
                $STH -> bindParam(":LeaseEndDate", date("Y-m-d", strtotime($data['lease_end_date'])));
				$STH -> bindParam(":Rent", $data['rent']);
                $STH -> bindParam(":SignedBy_agent", $data['signed_by_agent']);
                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
	}
	
	function delete($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_property_leases_DELETE
		(  
		   :Lease_id
		)");
	          $STH -> bindParam(":Lease_id", $data['lease_id']);
        	  $STH -> execute();
	}
	function update($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_property_leases_UPDATE
		( 
		  :Lease_id, 
		  :Property_id,
		  :User_id,
		  :LeaseStartDate,
		  :LeaseEndDate,
		  :Rent,
		  :SignedBy_agent  
		)");
                $STH -> bindParam(":Lease_id", $data['lease_id']);
				$STH -> bindParam(":Property_id", $data['property_id']);
				$STH -> bindParam(":User_id", $data['user_id']);
				$STH -> bindParam(":LeaseStartDate", date("Y-m-d", strtotime($data['lease_start_date'])));
				$STH -> bindParam(":LeaseEndDate", date("Y-m-d", strtotime($data['lease_end_date'])));
				$STH -> bindParam(":Rent", $data['rent']);
				$STH -> bindParam(":SignedBy_agent", $data['signed_by_agent']);
                $STH -> execute();
    }
    
    static function validate($post) {
        
        if(isset($post['lease_id'])) {
            if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['lease_id'])) {
                return false;
            }
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['property_id'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['user_id'])) {
            return false;
        }   
        
        if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['signed_by_agent'])) {
            return false;
        } 
        
       if(strlen($post['lease_start_date']) && strlen($post['lease_end_date'])) {
           if(strtotime($post['lease_end_date']) < strtotime($post['lease_start_date'])) {
               return false;
           }
       } else {
           return false;
       }
        
       if(!DataValidation::validateField(DataValidation::FIELD_INT, strtotime($post['lease_start_date']))) {
           return false;
       }
       
       if(!DataValidation::validateField(DataValidation::FIELD_INT, strtotime($post['lease_end_date']))) {
           return false;
       }

       if(!is_numeric($post['rent']) || $post['rent'] < 0) {
           return false;
       }
        
       return true;
    }
}
?>