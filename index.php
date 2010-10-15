<?php

/**
* Core9 Module Loader
*
* This is the module loader. It's a good place to put your login check routine before the actual loading of the modules.
* @author Basda <basda@nirvash.org>
* @version 10.07.001
* @link http://core9.googlecode.com
* @license LGPL
* @package Core9
* @subpackage Modules 
* @uses bootstrap.php
**/

/**
* Core9 initialization.
**/
require_once('bootstrap.php');

//Login routine
/*
* You can put in this place your login check routine. For example, you can define a $_SESSION variable when your users log in your page, and then check here if that variable exists.
* Remember to redirect to your login page if not. Of course, you can modify this behaviour to put this routine whenever you want.
*/
	
//Default modules
if(!isset($_GET['mod'])) $_GET['mod'] = 'index';
if(!isset($_GET['accion'])) $_GET['accion'] = 'index';

//Building the path to the module
$ruta = "controllers/".$_GET['mod'].".php";

//If that module doesn't exist we call the 404 error page from Core.
if(!file_exists($ruta)){
	$core->errorpage(404); 
	exit();
}

/**
* Calling the Header controller.
**/
require("controllers/head.php");

/**
* Calling the module controller.
**/
require($ruta);
	
/**
* Calling the Footer controller.
**/
require("controllers/foot.php");

?>