<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");
require_once(__DIR__ . "/Property.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/DataValidation.php");

class PropertyApplication extends DatabaseItem {  
    public $id, $property,$user,$firstName, $lastName, $address, $city, $state, $zip, $phone, $email, $lastUpdated;
    
    function __construct($databaseRowOrID = null) {
        if(is_array($databaseRowOrID)) {
            $this -> setDataFromDatabaseRow($databaseRowOrID);                
        } else {
            $STH = self::$DBH -> prepare("CALL PropertyApplication_construct(:id)");
            $STH -> bindParam(":id", $databaseRowOrID);
            $STH -> execute();
            $row = $STH -> fetch();
            $STH -> closeCursor();
            $this -> setDataFromDatabaseRow($row);
        }
    }
    
    static function validate($post) {
        
        if(isset($post['application_id'])) {
            if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['application_id'])) {
                return false;
            }
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['property_id'])) {
            return false;
        }
        
        if(!DataValidation::validateField(DataValidation::FIELD_DATABASE_ID, $post['user_id'])) {
            return false;
        }   
        
       if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['firstName'])) {
           return false;
       }

       if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['lastName'])) {
           return false;
       }

       if(!DataValidation::validateField(DataValidation::FIELD_EMAIL, $post['email'])) {
           return false;
       }

       if(!DataValidation::validateField(DataValidation::FIELD_PHONE, preg_replace("/[^0-9x]/", "", $post['phone']))) {
           return false;
       }

       if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['c_address'])) {
           return false;
       }
       
       if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['c_city'])) {
           return false;
       }
       
       if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['c_state'])) {
           return false;
       }
       
       if(!DataValidation::validateField(DataValidation::FIELD_STRING_REQUIRED, $post['c_zip'])) {
           return false;
       }
        
       return true;
    }
        
    function setDataFromDatabaseRow($row) {
        $this -> id = $row['application_id'];
        $this -> property = new Property($row['property_id']);
        $this -> user = new User($row['user_id']);
        $this -> firstName = $row['firstname'];
        $this -> lastName = $row['lastname'];
        $this -> address = $row['current_address'];
        $this -> city = $row['current_city'];
        $this -> state = $row['current_state'];
        $this -> zip = $row['current_zip'];
        $this -> phone =  preg_replace("/[^0-9x]/", "", $row['phone']);
        $this -> email = $row['email'];
        $this -> lastUpdated = $row['lastUpdated'];
    }
    
    static function getAll() {
        $STH = self::$DBH -> prepare("CALL PropertyApplication_getAll");
        $STH -> execute();
        
        $applications = array();
        $rows = $STH -> fetchAll();
        $STH -> closeCursor();
        foreach($rows as $row) {
            $applications[] = new PropertyApplication($row);
        }
        
        return $applications;
    }
    
    function insert($data)
    {
        $STH = self::$DBH -> prepare("CALL sp_property_applications_INSERT
        (  
          :user_id,
          :property_id,
          :firstName,
          :lastName,
          :address,
          :state,
          :city,
          :zip,
          :phone,
          :email  
        )");
          
                $STH -> bindParam(":property_id", $data['property_id']);
                $STH -> bindParam(":user_id", $data['user_id']);
                $STH -> bindParam(":firstName", $data['firstName']);
                $STH -> bindParam(":lastName", $data['lastName']);
                $STH -> bindParam(":address", $data['c_address']);
                $STH -> bindParam(":city", $data['c_city']);
                $STH -> bindParam(":state", $data['c_state']);
                $STH -> bindParam(":zip", $data['c_zip']);
                $STH -> bindParam(":phone", $data['phone']);
                $STH -> bindParam(":email", $data['email']);
                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
    }
    
    function delete($data)
    {
        $STH = self::$DBH -> prepare("CALL sp_property_applications_DELETE
        (  
           :application_id
        )");
              $STH -> bindParam(":application_id", $data['application_id']);
              $STH -> execute();
    }
    
    function update($data)
    {
        $STH = self::$DBH -> prepare("CALL sp_property_applications_UPDATE
        ( 
          :application_id,
          :user_id, 
          :property_id,
          :firstName,
          :lastName,
          :address,
          :state,
          :city,
          :zip,
          :phone,
          :email 
        )");
                $STH -> bindParam(":application_id", $data['application_id']);
                $STH -> bindParam(":property_id", $data['property_id']);
                $STH -> bindParam(":user_id", $data['user_id']);
                $STH -> bindParam(":firstName", $data['firstName']);
                $STH -> bindParam(":lastName", $data['lastName']);
                $STH -> bindParam(":address", $data['c_address']);
                $STH -> bindParam(":city", $data['c_city']);
                $STH -> bindParam(":state", $data['c_state']);
                $STH -> bindParam(":zip", $data['c_zip']);
                $STH -> bindParam(":phone", $data['phone']);
                $STH -> bindParam(":email", $data['email']);
                $STH -> execute();
    }
}
?>