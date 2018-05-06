<?php

namespace KudosApp;

include "config.php";

/**
 * Mysql database class - only one connection alowed - singleton pattern
 */

class Database {

	private static $_instance = null; 
	private $_connection;

	private function __construct() {
		try {
			$this->_connection = new \mysqli(HOST, USERNAME, PASSWORD, DATABASE);			
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