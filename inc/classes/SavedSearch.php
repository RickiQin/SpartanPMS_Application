<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . '/DatabaseItem.php');

class SavedSearch extends DatabaseItem {
	public $lastUpdated, $save_id, $user_id, $searchName, $lat, $lng, $rentMax, $rentMin, $bedrooms, $bathrooms, $available;
	
	function __construct($databaseRowOrID = null) {
        parent::__construct();
        if($databaseRowOrID) {
            if(is_array($databaseRowOrID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrID);                
            } else {
                $STH = self::$DBH -> prepare("CALL SavedSearch_construct(:id)");
                $STH -> bindParam(":id", $databaseRowOrID);
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
            }
        }
    }
	
	function setDataFromDatabaseRow($row) {
        $this -> save_id = $row['save_id'];
        $this -> user_id = $row['user_id'];
        $this -> searchName = $row['searchName'];
        $this -> lat = $row['latitude'];
        $this -> lng = $row['longitude'];
        $this -> rentMax = $row['rentMax'];
        $this -> rentMin = $row['rentMin'];
        $this -> bedrooms = $row['bedrooms'];
        $this -> bathrooms = $row['bathrooms'];
        $this -> available = $row['availabilityRequired'];
        $this -> lastUpdated = date("m/d/y h:ia", strtotime($row['lastUpdated']));
    }
	
	function create($search) {
		$lastUpdated = new Date;
	}

	function insert($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_user_saved_searches_INSERT 
		(  
		  :User_id,
		  :searchName,
		  :Latitude,
		  :Longitude,
		  :RentMin,
		  :RentMax,
		  :Bedrooms,
		  :Bathrooms,
		  :AvailabilityRequired  
		  )");
		  
				$STH -> bindParam(":User_id", $data['User_id']);
                $STH -> bindParam(":searchName", $data['searchName']);
                $STH -> bindParam(":Latitude", $data['Latitude']);
				$STH -> bindParam(":Longitude", $data['Longitude']);
                $STH -> bindParam(":RentMin", $data['RentMin']);
				$STH -> bindParam(":RentMax", $data['RentMax']);
                $STH -> bindParam(":Bedrooms", $data['Bedrooms']);
				$STH -> bindParam(":Bathrooms", $data['Bathrooms']);
				$STH -> bindParam(":AvailabilityRequired", $data['AvailabilityRequired']);
                $STH -> execute();

        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
	}
	
	function delete($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_user_saved_searches_DELETE 
		(  
		  :Save_id    
		  )");
                $STH -> bindParam(":Save_id", $data['Save_id']);
                $STH -> execute();
	}
	function update($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_user_saved_searches_UPDATE 
		( 
		  :Save_id, 
		  :User_id,
		  :sName,
		  :Latitude,
		  :Longitude,
		  :RentMin ,
		  :RentMax,
		  :Bedrooms,
		  :Bathrooms,
		  :AvailabilityRequired  
		  )");
                $STH -> bindParam(":Save_id", $data['Save_id']);
				$STH -> bindParam(":User_id", $data['User_id']);
                $STH -> bindParam(":sName", $data['searchName']);
				$STH -> bindParam(":Latitude", $data['Latitude']);
				$STH -> bindParam(":Longitude", $data['Longitude']);
				$STH -> bindParam(":RentMin", $data['RentMin']);
				$STH -> bindParam(":RentMax", $data['RentMax']);
				$STH -> bindParam(":Bedrooms", $data['Bedrooms']);
				$STH -> bindParam(":Bathrooms", $data['Bathrooms']);
				$STH -> bindParam(":AvailabilityRequired", $data['AvailabilityRequired']);
                $STH -> execute();
	}
}

?>