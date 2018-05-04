Steps to run app

1. Create empty database
2. Edit src/config.php file to set database credentials for database in point 1.
3. Import provided "kudos.sql" dump file to database
4. Run web server with command: php -S localhost:8000
4. Seed new sample data (only to counters table) with cli command:
	php seed.php 
	or 
	trig Seed option from browser on page http://localhost:8000/
		
======================================================================================================
======================================================================================================

Test requirements:

======================================================================================================

Request 1. Receive data from application. The data is sent by POST. The data is formatted in json.
The backend needs to decode this data and extract the "country" and "event" fields.
Then the backend needs to increment a counter in the database for the current day
for the respective country and event.

Answer:
To get this results make a call:
	Hit in your browser this url: 

	http://localhost:8000/send_json.php      (and this php file will do POST to receive_json.php)

	Change JSON data (country name, and event name) in send_json.php to see how is everything 
	processed and saved to database.

======================================================================================================

Request 2. The application does a GET request. Data should be returned in different formats (json,csv)
according to the request parameters. The response should contain the sum of each event
over the last 7 days by country for the top 5 countries of all times. 

Answer: 
To check results make a call in browser:

	http://localhost:8000/get_data.php?output=json
	or
	http://localhost:8000/get_data.php?output=csv