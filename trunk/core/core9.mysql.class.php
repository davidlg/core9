<?php

/**
* Create and manage connections to MySQL.
*
* Allows to use MySQL with Core9. Uses PHP's original driver for MySQL.
* @author Basda <admin@nirvash.org>
* @version $Id: mysql.class.php 215 2011-06-27 15:17:24Z miquelm $
* @license LGPL
* @copyright Core9 Project
* @link http://core9.googlecode.com
* @package Core9
* @subpackage CDBA
*/

/**
* Class for creating and using MySQL connections.
* 
* This class provides common functions to work with MySQL.
* @author Basda <admin@nirvash.org>
*/
class MySQL{	 
	/**
	* Connection resource representing the current connection to MySQL.
	*
	* @var resource
	*/
	protected static $db;
	
	/**
	* Total of querys executed in this session.
	*
	* @var integer
	*/
	public static $query_count;
	
	/**
	* Class constructor.
	*
	* Not needed since this class is a singleton.
	*/
	final private function __construct(){}
	
	/**
	* Class cloner.
	*
	* Not allowed in singletons.
	*/
	final private function __clone(){}
		
	/**
	* Class initialization.
	*
	* Opens the connection to the MySQL server and returns the current singleton instance.
	* @return object Current singleton instance.
	*/
	public static function mysql(){
		//Opening MySQL connection.
		//self::$db = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
		//mysql_select_db(DB_SCHEME, self::$db) or die(mysql_error());
		
		//Setting the character set.
		//mysql_query("SET CHARACTER SET '".DB_ENCODING."'", self::$db) or die(mysql_error(self::$db));
	}
	
	/**
	* Execute an SQL query.
	*
	* Executes an SQL query in the MySQL server and returns an associative array containing the results.
	* @param string $sql SQL query.
	* @return array Result from MySQL server.
	*/
	public function query($sql, $single_row=false){		
		//Executing the query
		$q = mysql_query($sql, self::$db);
		
		//Adding one to the query count
		self::$query_count++;
		
		//Processing the results
		if($q == false){
			die(mysql_error(self::$db));
		}elseif(!is_resource($q)){
			return true;
		}else{
			if(mysql_num_rows($q) > 0){			
				if(!$single_row){
					while($row = mysql_fetch_array($q)){
						foreach($row as $id=>$field){
							$row_result[$id] = addslashes($field);
						}
						
						$result[] = $row_result;
					}
				}else $result = mysql_fetch_array($q);
			}else $result = false;
			
			
			//Returning the results
			return $result;
		}
	}
	
	final public function __destruct(){
		mysql_close(self::$db);
	}
}

MySQL::mysql();

?>
