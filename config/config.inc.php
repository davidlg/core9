<?php

/**
* Configuration file for Core9
*
* @author Basda <admin@nirvash.org>
* @version $Id$
* @license LGPL
* @copyright Core9 Project
* @link http://core9.googlecode.com
* @package Core9
*/

/*
* Application information
*/

define('APP_TITLE', 'Core9');					//Application title (name)
define('APP_VERSION', '12.02&beta;');				//Current version

/*
* Path to the application
*/

define('APP_PATH', '/var/www/core9/');				//Physic path to the files in the server
define('APP_URL', 'http://myurl.com/');				//URL for access the application from the outside

/*
* Default controller
*/

define('MOD_DEFAULT', 'index');					//Default controller
define('ACT_DEFAULT', 'index');					//Default action

/*
* Database connection (MySQL by default)
*/

define('DB_HOST', 'myhost');					//Host
define('DB_USER', 'user');					//User
define('DB_PASS', 'password');					//Password
define('DB_SCHEMA', 'schema');					//Schema (database)
define('DB_ENCODING', 'utf8');					//Encoding (només MySQL)

/*
* Multi-language support
*/

define('ENABLE_ML', false);					//Enables or disables multi-language
define('ML_PATH', getcwd().'/lang');				//Path to the language files
define('ML_DEFAULT', 'es');					//Default language

/*
* Webservice configuration
*/

define('API_PATH', 'api/');					//Path to the webservice files
define('API_FILE_EXT', '.api.php');				//Default extension for webservice files
define('API_NAME', 'core9');					//API name
define('API_URN', 'urn:core9');					//API URN
define('API_URL', 'http://miurl.com/api.php');			//Path to access the webservice from the outside

?>
