<?php

/**
* Core9 initialization.
*
* This script loads required files and initializes the Core, among other things.
* @author Basda <admin@nirvash.org>
* @version $Id: bootstrap.php 224 2011-08-08 06:03:37Z miquelm $
* @copyright Core9 Project
* @link http://core9.googlecode.com
* @license LGPL
* @package Core9
* @subpackage Core9
* @uses APP_PATH Path to where system files are stored.
*/

//Encoding. Default is UTF-8.
header("Content-type: text/html; charset=utf-8");

//Session initialization
session_start();

//Debugging
//This value should be 0 in production servers
ini_set('display_errors', 1);
date_default_timezone_set("Europe/Madrid");

/**
* Configuration file. Among other things, here is defined the database connection.
*/
require_once('config/config.inc.php');

/**
* The Core class set.
*/
$core_dir = scandir('core');
foreach($core_dir as $core_class) if(!is_dir('core/'.$core_class) && substr($core_class, -1, 1) != "~" && substr($core_class, 0, 1) != '.') require_once('core/'.$core_class);

/**
* The DAO classes set.
*/
$class_dir = scandir('class');
foreach($class_dir as $class) if(!is_dir('class/'.$class) && substr($class, -1, 1) != "~" && substr($class, 0, 1) != '.') require_once('class/'.$class);

/**
* The Controllers classes.
*/
$controller_dir = scandir('controllers');
foreach($controller_dir as $controller_class){
	if(!is_dir('controllers/'.$controller_class) && substr($controller_class, -1, 1) != "~" && substr($controller_class, 0, 1) != '.' && substr($controller_class, -7, 7) != "lib.php"){
		//echo "Activating: ".$controller_class."<br />";
		require_once('controllers/'.$controller_class);
	}
}

/**
* Smarty.
*/
require_once('smarty/Smarty.class.php');

//Core initialization
Core::core();

//Working directory.
//This directory is defined in config.inc.php.
if(is_dir(APP_PATH)) chdir(APP_PATH);
else{
	Core::render("index/help");
	exit();
}


//Configuration
Core::assign('APP_PATH', APP_PATH);
Core::assign('APP_URL', APP_URL);
Core::assign('APP_TITLE', APP_TITLE);
Core::assign('APP_VERSION', APP_VERSION);
Core::assign('MOD_DEFAULT', MOD_DEFAULT);
Core::assign('ACT_DEFAULT', ACT_DEFAULT);

?>
