<?php

/**
* WIP - MS SQL Server wrapper for Core9
*/

class mssql{
	protected static $db;
	
	final private function __construct(){}
	final private function __clone(){}
	
	public static function mssql(){
		//self::$db = mssql_connect(DB_HOST, DB_USER, DB_PASS) or die(mssql_get_last_message());
		//mssql_select_db(DB_SCHEMA, self::$db) or die(mssql_get_last_message());
	}
	
	public static function query($sql, $single_row=false){
		$q = mssql_query($sql, self::$db) or die(mssql_get_last_message());
		
		if($q == false){
			trigger_error(E_USER, "CORE9 DBA Error: ".mssql_get_last_message());
		}elseif(!is_resource($q)){
			return true;
		}else{
			if(mssql_num_rows($q) > 0){
				if(!$single_row){
					while($row = mssql_fetch_array($q, MSSQL_ASSOC)){
						foreach($row as $id=>$field){
							$row_result[$id] = utf8_encode($field);
						}
						
						$result[] = $row_result;
					}
				}else $result = mssql_fetch_array($q, MSSQL_ASSOC);
			}else $result = false;
						
			//Returning the results
			return $result;
		}
	}
	
	final private function __destruct(){
		mssql_close(self::$db);
	}
}

mssql::mssql();

?>
