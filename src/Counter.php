<?php

namespace KudosApp;
use KudosApp\Database;

class Counter
{

	public function updateCounter ($countryId, $eventId)
	{
	    try {  
    		$db = Database::getInstance();
    		$conn = $db->getConnection();

	        $datum = date('Y-m-d');

	        $sql = "SELECT id FROM counters WHERE country_id = $countryId AND event_id = $eventId AND date=\"$datum\"";
	        $result = $conn->query($sql);
	        if ($result->num_rows > 0) {        // exists date, coutryId, eventId in a table, just do count++ 
	            $updateSql = "UPDATE counters SET count=count+1 WHERE country_id=$countryId AND event_id=$eventId AND date=\"$datum\"";
	            $updateResult = $conn->query($updateSql);
	            if ($updateResult === true) 
	                return true;
	            return false;            
	        } else {                            // no record for today, this country and this event so add new record
	            $insertSql = "INSERT INTO counters (date, country_id, event_id, count) VALUES (\"$datum\", $countryId, $eventId, 1)";
	            $insertResult = $conn->query($insertSql);
	            if ($insertResult === false) 
	                return false;
	            return true;
	        } 
	    }
	    catch (Exception $e) {
	        echo "Exception error in Counter class\n";
	    }
	}

	public function seedData ()
	{
	    $writeDate = strtotime("May 1, 2018");         // day we start from
		
	    try {  
    		$db = Database::getInstance();
    		$conn = $db->getConnection();

	        $sql = "TRUNCATE TABLE counters";
	        $conn->query($sql);

	        for ($day=1; $day<=10; $day++) {                                // days 1 to day 10
	            
	            $insertDate = date('Y-m-d', strtotime("+". $day ."day", $writeDate));
	            for ($country=1; $country<=10; $country++) {                // countries 1 to 10
	                for ($event=1; $event<=3; $event++) {                   // events 1 to 3 (view, play, click)

	                    $counters = rand (1,100);

	                    $sql = "INSERT INTO counters 
	                            (date, country_id, event_id, count) 
	                            VALUES (\"$insertDate\", \"$country\", \"$event\", \"$counters\")";
	                    if ($conn->query($sql) !== true) {
	                        return false;
	                    }
	                }
	            }
	        }
	        return true;
	    }
	    catch (Exception $e) {
	        echo "Exception error in seedData class\n";
	    }
	}	
}