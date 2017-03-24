<?php

class DatabaseItem {
    public static $DBH = null;
    
    function __construct() {
        if(DatabaseItem::$DBH == null) {
            try {
                $dbuser = "spartan";
                $pass = "spartan2013";
                $host = "localhost";  
                $dbname = "spartan_db"; 
                DatabaseItem::$DBH = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $pass); 
                DatabaseItem::$DBH -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                DatabaseItem::$DBH -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                DatabaseItem::$DBH -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );      
            } catch(PDOException $e) {
                echo $e -> getMessage();
                file_put_contents('./PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
            }
        }
    }
}

?>