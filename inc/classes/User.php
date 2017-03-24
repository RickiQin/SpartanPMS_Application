<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/Authentication.php");
require_once(__DIR__ . "/DatabaseItem.php");
require_once(__DIR__ . "/Property.php");
require_once(__DIR__ . "/PropertyDetails.php");
require_once(__DIR__ . "/SavedSearch.php");
require_once(__DIR__ . "/SavedProperty.php");
require_once(__DIR__ . "/DataValidation.php");

class User extends DatabaseItem {
	public $id, $department, $firstName, $lastName, $emailAddress, $phone, $dateAdded, $isLoggedIn;
	private $password, $userID;
	
    function __construct($databaseRowOrID = null) {
        parent::__construct();
        if(is_null($databaseRowOrID)) { 
            // if user is logged in...
            if(Authentication::login_check(self::$DBH)) {
                $this -> userID = Authentication::getUserID();
                $this -> getUserRowForID($this -> userID);
                $this -> isLoggedIn = true;
            }
        } else {
            if(is_array($databaseRowOrID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrID);
            } else {
                $this -> getUserRowForID($databaseRowOrID);
            }
        }
    }
    
    function getUserRowForID($id) {
        $STH = self::$DBH -> prepare("CALL User_getUserRowForID(:id)");
        $STH -> bindParam(":id", $id);
        $STH -> execute();
        $this -> setDataFromDatabaseRow($STH -> fetch());
        $STH -> closeCursor();
    }
    
    function setDataFromDatabaseRow($row) {
        $this -> id = $row['user_id'];
        $this -> department = $row['department_id'];
        $this -> firstName = $row['firstName'];
        $this -> lastName = $row['lastName'];
        $this -> emailAddress = $row['emailAddress'];
        $this -> phone = $row['phone'];
    }
    
	function getSavedSearches() {
	    $STH = self::$DBH -> prepare("CALL User_getSavedSearches(:id)");
        $STH -> bindParam(":id", $this -> userID, PDO::PARAM_INT);
        $STH -> execute();
        $savedSearches = array();
        while($row = $STH -> fetch()) {
            $savedSearches[] = new SavedSearch($row);
        }
        return $savedSearches;
	}
	
	function getSavedProperties() {
	    $STH = self::$DBH -> prepare("CALL User_getSavedProperties(:id)");
        $STH -> bindParam(":id", $this -> userID, PDO::PARAM_INT);
        $STH -> execute();
        $savedProperties = array();
        while($row = $STH -> fetch()) {
            $savedProperties[] = new Property($row['property_id']);
        }
        return $savedProperties;
	}
    
    function hasAppliedForProperty($propertyID) {
        $STH = self::$DBH -> prepare("CALL User_hasAppliedForProperty(:prop_id, :userID)");
        $STH -> bindParam(":prop_id", $propertyID);
        $STH -> bindParam(":userID", $this -> userID);
        $STH -> execute();
        if($row = $STH -> fetch()) {
            return $row['application_id'];    
        }
        
        return false;
    }
    
    static function getUsersByDepartment($department = null, $department2 = null) {
        if(isset($department)) {
            if(isset($department2)) {
                $STH = self::$DBH -> prepare("CALL User_getUsersByDepartment_1(:departmentID, :departmentID2)");
                $STH -> bindParam(":departmentID", $department);
                $STH -> bindParam(":departmentID2", $department2);
            } else {
                $STH = self::$DBH -> prepare("CALL User_getUsersByDepartment_2 (:departmentID)");
                $STH -> bindParam(":departmentID", $department);
            }
            $STH -> execute();
        } else {
            $STH = self::$DBH -> query("CALL User_getUsersByDepartment_3");
        }
        
        $users = array();
        while($row = $STH -> fetch()) {
            $users[] = new User($row);
        }
        
        return $users;
    }
	
	function getPropertyLeases() {
		$STH = self::$DBH -> prepare("CALL User_getPropertyLeases(:userID)");
        $STH -> bindParam(":userID", $this -> userID);
        $STH -> execute();
        return $STH -> fetchAll();
	}
	
	function login($email, $password) {
	   return Authentication::login($email, $password, self::$DBH);
	}
	
	function logout() {
	    header("Location: " . Authentication::LOGOUT_URL);
	}
    
    function validateAndCreate($data) {
        // VERIFY ALL REQUIRED FIELDS HAVE DATA
        if(!(strlen($data['firstname']) && strlen($data['lastname']) && strlen($data['email']) && strlen($data['password'])))
            return false; 

        // Make sure email is unique
        $STH = self::$DBH -> prepare("CALL User_validateAndCreate(:email)");
        $STH -> bindParam(":email", $data['email']);
        $STH -> execute();
        $result = $STH -> fetch();
        if($result['alreadyExists'] > 0) {
            return false;
        }
        // VALIDATE EMAIL
        if(!DataValidation::validateField(DataValidation::FIELD_EMAIL, $data['email'])) 
            return false;
        
        if(!DataValidation::validateField(DataValidation::FIELD_PASSWORD, $data['password'])) 
            return false;
        
        if($data['password'] != $data['passwordconf']) 
            return false;
        
        $data['phone'] = preg_replace("/[^0-9]+/", "", $data['phone']);
        
        // PASSED ON VALIDATION
        $this -> create($data);
        
        return true;
    }
    
    function create($data) {
        try {    
            $STH = self::$DBH -> prepare("CALL sp_users_INSERT (  
              :departmentID,
              :firstName, 
              :lastName,
              :emailAddress,  
              :password,
              :phone  
            )");
            
            if(isset($data['department_id'])) {
                $STH -> bindParam(":departmentID", $data['department_id']); // CLIENT
            } else {
                $STH -> bindValue(":departmentID", 5); // CLIENT
            }
            
            $STH -> bindParam(":firstName", $data['firstname']);
            $STH -> bindParam(":lastName", $data['lastname']);
            $STH -> bindParam(":emailAddress", $data['email']);
            $STH -> bindParam(":password", hash("sha512", $data['password']));
            $STH -> bindParam(":phone", $data['phone']);
            
            $STH -> execute();
        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    }
	
	//This may not be a required, but I added it anyway just in case. -Ben-
	function insert($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_users_INSERT 
		(  
		  :Department_id,
		  :FirstName, 
		  :LastName,
		  :EmailAddress,  
		  :Password,
		  :Phone  
		)");
		  
				$STH -> bindParam(":Department_id", $data['department_id']);
                $STH -> bindParam(":FirstName", $data['firstname']);
				$STH -> bindParam(":LastName", $data['lastname']);
                $STH -> bindParam(":EmailAddress", $data['emailaddress']);
				$STH -> bindParam(":Password", $data['password']);
                $STH -> bindParam(":Phone", $data['phone']);
                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
	}
	
	function delete($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_users_DELETE 
		(  
		  :User_id   
		)");
	          $STH -> bindParam(":User_id", $data['user_id']);
        	  $STH -> execute();
	}
	function update($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_users_UPDATE
			(  
			  :User_id,
			  :Department_id,
			  :FirstName, 
			  :LastName,
			  :EmailAddress,  
			  :Password,
			  :Phone  
			)");
                $STH -> bindParam(":User_id", $data['user_id']);
				$STH -> bindParam(":Department_id", $data['department_id']);
				$STH -> bindParam(":FirstName", $data['firstname']);
				$STH -> bindParam(":LastName", $data['lastname']);
				$STH -> bindParam(":EmailAddress", $data['emailaddress']);
				$STH -> bindParam(":Password", $data['password']);
				$STH -> bindParam(":Phone", $data['phone']);
                $STH -> execute();
	}
}

?>