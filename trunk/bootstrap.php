<?php

/**
* Core9 initialization.
*
* This is the file that actually loads the Core and starts pretty much everything. Also, you can put here whatever you want done before the actual page begins loading.
* @author Basda <basda@nirvash.org>
* @version 10.10
* @copyright 2009-2010 Estudio Vakadas
* @link http://www.vakadas.com
* @license LGPL
* @package Core9
* @subpackage Bootstrap
* @uses $app_path Path to where Core9's files are located. Lookup this definition in config/config.inc.php.
**/

//We start the PHP's built-in session manager to store data between page loads
session_start();

//Turn this off (put it to 0) when your application is in production. It will prevent the E_WARNING level errors to show up in your page.
//Turn it on when developing and debugging to see the errors.
ini_set('display_errors', 1);

//Default timezone for date calculation. Change this if you need to.
date_default_timezone_set('Europe/Madrid');

/**
* Configuration file. This is where you set up your database connection and some constant variables.
**/
require_once("config/config.inc.php");

//Checking if the working directory defined in APP_PATH really exists. If not, we can't continue and we issue a Fatal Error.
//Note that, as we couldn't locate the working directory, we can't load the Core at this point, thus preventing us to call the Core9 built-in error page.
if(is_dir(APP_PATH)) chdir(APP_PATH);
else die('CORE9 Bootstrap: Error fatal - La ruta a la aplicación no existe. Revise el fichero config/config.inc.php y ajuste el parámetro APP_PATH.');

/**
* Smarty initialization. As Core9 is built as an Smarty extension we are required to load this _before_ actually loading the Core9's Core.
**/
require_once("smarty/Smarty.class.php");

/**
* Now, this is the real thing. The Core9's Core, heart of the framework. Besides initializing the Smarty engine and doing some set ups, it does some
* low-level working like error pages and so.
**/
require_once("core/core.class.php");

//Creating the -unique- instance of Core.
$core = new Core();

//Setting up the character encoding to use within our application. I suggest using UTF-8 for best results and better compatibility.
header("Content-type: text/html; charset=utf-8");

?>
