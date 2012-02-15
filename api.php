<?php

require_once("bootstrap.php");
require_once("lib/soap/nusoap.php");

$server = new soap_server();

$server->configureWSDL(API_NAME, API_URN, API_URL);

//Path to the API files (check out config/config.inc.php)
$ar_api = scandir(API_PATH);

//This loop loads every API file found in the path.
if(count($ar_api)){
	foreach($ar_api as $file){
		$file_ext_length = strlen(API_FILE_EXT);
		
		if(is_file('api/'.$file) && substr($file, ($file_ext_length*-1), $file_ext_length) == API_FILE_EXT)
			require_once('api/'.$file);
	}
}

//Initializing the nuSOAP server.
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);

?>
