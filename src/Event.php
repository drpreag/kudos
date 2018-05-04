<?php

namespace KudosApp;
use KudosApp\Database;

class Event
{

	public function eventIdByName ($eventName)
	{
	    try {  
    		$db = Database::getInstance();
    		$conn = $db->getConnection();

	        $sql = "SELECT id FROM events WHERE name = \"$eventName\"";

	        $result = $conn->query($sql);
	        if ($result->num_rows > 0) {
	            $row = $result->fetch_assoc();            
	            return $row['id'];
	        } else
	            return null;
	    }
	    catch (Exception $e) {
	        echo "Exception error in Event class\n";
	    }
	}	
}