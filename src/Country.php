<?php

namespace KudosApp;
use KudosApp\Database;

class Country
{

	public function getTopFiveCountriesPerEvent () 
	{
	// returns array 
	    try {  
    		$db = Database::getInstance();
    		$conn = $db->getConnection();

	        $sql = "SELECT 
	                    events.id AS event_id,
	                    events.name AS event_name,
	                    countries.id AS country_id,
	                    countries.name AS country_name,
	                    SUM(counters.count) AS sum_country_event
	                FROM
	                    ((counters
	                    LEFT JOIN events ON ((events.id = counters.event_id)))
	                    LEFT JOIN countries ON ((countries.id = counters.country_id)))
	                WHERE
	                    (counters.date >= (CAST(NOW() AS DATE) - INTERVAL 7 DAY))
	                GROUP BY counters.event_id , counters.country_id
	                ORDER BY counters.event_id , sum_country_event DESC";

	        $result = $conn->query($sql);

	        if ($result->num_rows > 0) 
	            $rows = $result->fetch_all(MYSQLI_ASSOC);
	        else 
	            return null;

	        $view = [];     $viewCount=1;
	        $play = [];     $playCount=1;
	        $click = [];    $clickCount=1;
	        
	        foreach ($rows as $row) {                           // area size is number of coutries * 3

	            if ($row['event_id']==1 and $viewCount<=5) {    // pull first 5 ranked countries by views
	                $row['rank'] = $viewCount;
	                $view[] = $row;
	                $viewCount++;
	            }
	            if ($row['event_id']==2 and $playCount<=5) {    // pull first 5 ranked countries by plays
	                $row['rank'] = $playCount;                
	                $play[] = $row;
	                $playCount++;
	            }
	            if ($row['event_id']==3 and $clickCount<=5) {   // pull first 5 ranked countries by clicks
	                $row['rank'] = $clickCount;                
	                $click[] = $row;
	                $clickCount++;
	            }                                
	        }
	        return array_merge ($view, $play, $click);
	    }
	    catch (Exception $e) {
	        echo "Exception error in Country class\n";
	    }        
	}	

	public function countryIdByName ($countryName)
	{
	    try {  
    		$db = Database::getInstance();
    		$conn = $db->getConnection();

	        $sql = "SELECT id FROM countries WHERE name = \"$countryName\"";

	        $result = $conn->query($sql);
	        if ($result->num_rows > 0) {
	            $row = $result->fetch_assoc();            
	            return $row['id'];
	        } else
	            return null;
	    }
	    catch (Exception $e) {
	        echo "Exception error in Country class\n";
	    }
	}

	public function getTopFiveCountriesPerEvent_with_mysql_rank () 
	{
	/* 
	    elegant and easy solution, BUT somehow ranking query that is working perfectly in MySQL 
	    is not working in PHP, but maybe related to my environment.
	    So I provided another function for this job called getTopFiveCountriesPerEvent
	*/
	    try {  
    		$db = Database::getInstance();
    		$conn = $db->getConnection();

	        $sql = "SELECT *
	                FROM 
	                    ( SELECT event_id, event_name, country_id, country_name, sum_country_event,
	                        @rank :=  IF(@current_event = event_id, @rank + 1, 1) AS rank, 
	                        @current_event := event_id
	                        FROM counters_query 
	                        ORDER BY event_id, sum_country_event DESC
	                    ) ranked 
	                WHERE rank <=5";
	        $result = $conn->query($sql);

	        if ($result->num_rows > 0)
	            return $result->fetch_all(MYSQLI_ASSOC);
	        else
	            return null;
	    }
	    catch (Exception $e) {
	        echo "Exception error in Country class\n";
	    }
	}	

}