<?php

/**
* Ajax auxiliary file loader.
*
* This is pretty much like the Module Loader we have in index.php, but for Ajax auxiliary files.
* These files are located in the ajax/ directory.
* @author Basda <basda@nirvash.org>
* @version 10.10
* @license LGPL
* @package Core9
* @subpackage Modules
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

//Building the path to the module. Ajax auxiliary files are organized like this: ajax/<module>/<action/page>.
$ruta = "ajax/".$_GET['mod']."/".$_GET['accion'].".ajax.php";

//If that module doesn't exist we call the 404 error page from Core.
if(!file_exists($ruta)){
	$core->errorpage(404); 
	exit();
}

/**
* Calling the module.
**/
require($ruta);

?>
