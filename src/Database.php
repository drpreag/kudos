<?php

namespace KudosApp;

include "config.php";

/**
 * Mysql database class - only one connection alowed - singleton pattern
 */

class Database {

	private static $_instance = null; 
	private $_connection;

	private $_host;
	private $_username;
	private $_password;
	private $_database;	

	private function __construct() {
		$this->_host = getenv("HOST");
		$this->_username = getenv("USERNAME");
		$this->_password = getenv("PASSWORD");
		$this->_database = getenv("DATABASE");		

		try {
			$this->_connection = new \mysqli($this->_host, $this->_username, 
				$this->_password, $this->_database);
		}
		catch (Exception $e) {
	        echo "Exception error in Database class\n";
	    }
	}

	public static function getInstance() {
		if(!self::$_instance) { 				// If no instance then make one
			self::$_instance = new Database();
		}
		return self::$_instance;
	}

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}


/**
 *	to make this work use it like this primer: 
 *
 *    $db = Database::getInstance();
 *    $conn = $db->getConnection(); 
 *    $sql_query = "SELECT foo FROM .....";
 *    $result = $conn->query($sql_query);
 */
?>