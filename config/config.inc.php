<?php

/**
* Core9 main configuration file.
*
* This file defines some constant values and the database connection (defined in the $dbi variable). Important values here are the APP_PATH and APP_URL definitions, which
* indicates the Core9's core where to lookup for system files and includes.
* @author Basda <basda@nirvash.org>
* @version 10.10
* @license LGPL
* @package Core9
* @subpackage Config
**/

/**
* Put here your application's name. If you want this value passed to any Smarty template remind to make the assignment ($core->assign()) in the module controller.
* @name $app_nombre
**/
define('APP_NAME', 'Core9 Test Run');

/**
* Put here your application version. Same as APP_NAME apply.
* @name $app_version
**/
define('APP_VERSION', '10.10 &alpha;');

/**
* Physical path to where system files are located.
* @name $app_path
**/
define('APP_PATH', getcwd());

/**
* Relative URL to use within the HTML code. This is used to make Apache's mod_rewrite work properly.
* @name $app_url
**/
define('APP_URL', '/Core9');

/**
* Character encoding to use in database connections (applicable for MySQL at this time).
* @name $dba_collate
**/
define('DBA_COLLATE', 'utf8');

/* MYSQL Connection definition */
$dbi = array(
	'host'=>'192.168.1.250',
	'user'=>'core9',
	'password'=>'core9',
	'database'=>'core9'
);

?>
