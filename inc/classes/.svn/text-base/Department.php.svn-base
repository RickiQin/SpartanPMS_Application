<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once(__DIR__ . "/DatabaseItem.php");

class Department extends DatabaseItem {
	public $name;
	
	function __construct($databaseRowOrID = null) {
        parent::__construct();
        if($databaseRowOrID) {
            if(is_array($databaseRowOrID)) {
                $this -> setDataFromDatabaseRow($databaseRowOrID);                
            } else {
                $STH = self::$DBH -> prepare("department_select_all(:dep_id)");
                $STH -> bindParam(":dep_id", $databaseRowOrID);
                $STH -> execute();
                $this -> setDataFromDatabaseRow($STH -> fetch());
            }
        }
    }
	
	function setDataFromDatabaseRow($row) {
        $this -> name = $row['name'];
    }
	
	function insert($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_departments_INSERT
		( 
		  :Name
		)");
                $STH -> bindParam(":Name", $data['name']);
                $STH -> execute();
				
        $STH = self::$DBH -> query("CALL Last_Insert_ID()");       
        $lastId = $STH->fetch(PDO::FETCH_NUM);
        $lastId = $lastId[0];
                 
        return $lastId;
	}
	
	function delete($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_departments_DELETE
		( 
		  :Department_id
		)");
                $STH -> bindParam(":Department_id", $data['department_id']);
                $STH -> execute();
	}
	function update($data)
	{
		$STH = self::$DBH -> prepare("CALL sp_departments_UPDATE
		( 
		  :Department_id,
		  :Name
		)");
                $STH -> bindParam(":Department_id", $data['department_id']);
				$STH -> bindParam(":Name", $data['name']);
                $STH -> execute();
	}
	
}

?>