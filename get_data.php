<?php

namespace KudosApp;
require 'vendor/autoload.php';

//include "src/functions.php"; // ?

use KudosApp\Country;

$country = new Country;

// Call this way:
// /get_data.php?output=json
// or
// /get_data.php?output=csv

if ($_GET["output"]=='json') {
	$result = $country->getTopFiveCountriesPerEvent();
	//$result = $country->getTopFiveCountriesPerEvent_with_mysql_rank();

	if ($result)
	    print json_encode($result, JSON_PRETTY_PRINT);
	else
	    echo "No Data found for json output\n";
	die();
}

if ($_GET["output"]=='csv') {
	$result = $country->getTopFiveCountriesPerEvent();

	if ($result)
	    outputCsvData ("test-result.csv", $result);
	else
	    echo "No Data found for csv export\n";
	die();	
}

echo "Format to call: /get_data.php?output=json or /get_data.php?output=csv";
die();

function outputCsvData ($fileName, $data) 
{

    if(isset($data['0'])) { 

    	$fp = fopen("/tmp/_".$fileName, 'w');   

        fputcsv($fp, array_keys($data['0'])); 		// print csv header		

    	foreach ( $data as $row )					// print csv data, 5 ranked countries * 3 events = 15 records
	        fputcsv($fp, $row);

      	fclose($fp);
	    header("Content-Type: text/csv");
    	header("Content-Disposition: attachment; filename=/tmp/_".$fileName);
		readfile("/tmp/_".$fileName);
   	}
}