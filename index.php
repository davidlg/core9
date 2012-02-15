<?php

/**
* Application initialization.
*
* @author Basda <admin@nirvash.org>
* @version $Id: index.php 224 2011-08-08 06:03:37Z miquelm $
* @copyright Core9 Project
* @link http://core9.googlecode.com
* @license LGPL
* @package Core9
*/

/**
* Core9 initialization.
*/
require_once('bootstrap.php');

if(!isset($_GET['mod']) || $_GET['mod'] == 'index') $_GET['mod'] = 'index';

//Inicializando controlador
$mod_name= $_GET['mod'].'Controller';

$controller = new $mod_name();

?>