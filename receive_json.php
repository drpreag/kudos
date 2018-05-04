<?php

namespace KudosApp;
require 'vendor/autoload.php';

use KudosApp\Country;
use KudosApp\Event;
use KudosApp\Counter;

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);
 
//If json_decode failed, the JSON is invalid.
if(!is_array($decoded)){
    throw new Exception('Received content contained invalid JSON!');
}

$country = new Country;
$event = new Event;
$counter = new Counter;

foreach ($decoded as $key=>$value) {
	if ($key == "country") 
		$countryId = $country->countryIdByName ($value);
	if ($key == "event") 
		$eventId = $event->eventIdByName ($value);
}

if ($counter->updateCounter ($countryId, $eventId))
	echo "Counters updated\n";
else
	echo "Update failed\n";
