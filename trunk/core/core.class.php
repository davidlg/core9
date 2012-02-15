<?php

/**
* Core class for Core9 Framework.
*
* Core takes care of the template rendering, plugin loading and some basic stuff.
* @author Basda <admin@nirvash.org>
* @version $Id: core.class.php 217 2011-07-01 08:46:03Z miquelm $
* @copyright Core9 Project
* @link http://core9.googlecode.com
* @license LGPL
* @package Core9
* @subpackage Core9
*/

define('CORE9_STARTUP', 0);
define('CORE9_BEFORE_RENDERING', 10);
define('CORE9_AFTER_RENDERING', 80);
define('CORE9_FINISH', 90);

define('CDBA_QUERY_NORMAL', false);
define('CDBA_QUERY_SINGLE', true);

/**
* Core class for Core9 Framework.
*
* Core is a singleton, so it can't be instantiated. Instead it is initialized in bootstrap.php and can be called from
* anywhere in Core9 by using the :: operator.
*/
class Core{
	/**#@+
	* Instances for objects used during running time.
	*/
	
	/**
	* Current instance of Core.
	*
	* @var object
	*/
	private static $instance;
	
	/**
	* Current instance of Smarty.
	*
	* @var object
	*/
	private static $smarty;
	/**#@-*/
	
	private static $runlevel;
	private static $services;
	private static $map;
	
	/**
	* Current version of Core.
	* @var string
	*/
	const core9_version = '11.06 TERMINUS RC2';
	
	private function __construct(){}
	public function __destruct(){}
	private function __clone(){}
	
	/**
	* Core initialization.
	*
	* Being a singleton Core does not have an actual constructor. It's initialization is done in this method,
	* and should be called right after including the class (usually done in bootstrap.php). It will then return
	* an instance that will allow the use of the Core anywhere in the application.
	* @return object Core
	* @static
	*/
	public static function core(){
		//Initializing the Smarty template rendering engine. Core relies on it for template management.
		self::$smarty = new Smarty();
		self::$smarty->Smarty();
		
		//Smarty configuration.
		//At some point we should move this to the configuration file.
		self::$smarty->template_dir = getcwd().'/templates/';
		self::$smarty->compile_dir = getcwd().'/templates_c/';
		self::$smarty->config_dir = getcwd().'/config/';
		self::$smarty->cache_dir = getcwd().'/cache/';
		self::$smarty->caching = false;
		
		//Exposing Core9 version to all templates
		self::assign('core9_version', self::version());
		
		//Is multilanguage support (ML) enabled in configuration?
		if(ENABLE_ML){
			//Yes, it is. Load the specified or default language.
			$language = (empty($_COOKIE["lang"])) ? ML_DEFAULT : $_COOKIE["lang"];
			
			self::load_language($language);
		}
		
		self::change_runlevel(CORE9_STARTUP);
		
		//This class is a singleton, so we check if the class was initialized before. If not we create
		//a new instance. The current instance is stored in the $instance variable, at the top of this class.
		if(!isset(self::$instance)){
			$c = __CLASS__;
			self::$instance = new $c;
		}
		
		//Finally we return the instance so Core can be used anywhere.
		return self::$instance;
	}
	
	/**
	* Returns the current version for Core.
	*
	* Version is defined in Core's constants.
	* @uses core9_version
	* @return string Current version of Core
	*/
	public function version(){
		return self::core9_version;
	}
	
	public function change_runlevel($runlevel){
		self::$runlevel = $runlevel;
		
		if(is_array(self::$services)){
			foreach(self::$services as $service){
				if($service->runlevel <= $runlevel && $service->status == 0){
					$service->start();
				}elseif($service->runlevel > $runlevel && $service->status == 1){
					$service->stop();
				}
			}
		}
	}
	
	/**
	* Module loader.
	*
	* This method allows to load Core9 modules. A module is a .php file stored in a folder under '/modules'. When
	* browsing to 'www.myserver.com/users/profile' you are in fact calling the 'profile' method from the file
	* 'users.php' inside '/modules'. Each of this methods are meant to load a Smarty template.
	*
	* Default module is 'index', and default action is 'index' too. They will be called if no module or action are
	* specified.
	* @param string $module Module (.php file) that stores the action we are calling.
	* @param string $action Action (method) that we want to execute.
	*/
	/*public function load($module, $action){
		//Adding the prefix "action_" to the action string
		$action = 'action_'.$action;
		
		//Loading the module
		$mod_load = new $module();
		
		//Calling the specificed action		
		self::change_runlevel(CORE9_BEFORE_RENDERING);
		
		$mod_load->$action();
		
		self::change_runlevel(CORE9_AFTER_RENDERING);
		
		self::change_runlevel(CORE9_FINISH);
	}*/
	
	public function register_map($map){
		self::$map = $map;		
	}
	
	public function execute($action){
		$function = self::$map[$action];
				
		self::register_services($function['services']);
		
		self::change_runlevel(CORE9_BEFORE_RENDERING);
		
		$function['action']();
		
		//self::change_runlevel(CORE9_AFTER_RENDERING);
		
		//self::change_runlevel(CORE9_FINISH);
	}
	
	public function redirect($mod, $action, $args=''){
		die('<script>document.location.href="'.APP_URL.$mod.'/'.$action.$args.'";</script>');
	}
		
	public function register_services($services){		
		if(is_array($services)){
			foreach($services as $service){
				$path = 'services/'.$service.'.service.php';
				
				if(file_exists($path)){
					require_once($path);
					self::$services[] = new $service;
				}else trigger_error('Core9: Unable to find the service '.$service.' in the /services/ folder.', E_USER_ERROR);
			}
		}
	}		
	
	/**
	* Register a block-plugin for Smarty.
	*
	* @param string $blockname Name for the Block
	* @param string $function Function associated with the Block
	*/
	public function register_block($blockname, $function){
		self::$smarty->register_block($blockname, $function);
	}
	
	/**
	* Assign a value to a Smarty variable.
	*
	* Smarty variables are passed to Smarty templates so they can be used on them. A variable value can be anything
	* allowed by PHP, including objects and arrays. Refer to Smarty documentation for more information.
	* @param string $variable Variable name
	* @param string $valor Value for that variable
	*/
	public function assign($variable, $valor){
		self::$smarty->assign($variable, $valor);
	}
	
	/**
	* Retrieve the value of a Smarty variable.
	*
	* Returns the value of the specified variable. This variable must be declared previously using assign().
	* Useful when retrieving values using render_plain() instead of render().
	* @param string $variable Name of the variable
	* @return mixed Value of the variable
	*/
	public function get_var($variable){
		return self::$smarty->get_template_vars($variable);
	}
	
	/**
	* Render a template.
	*
	* This method tells Smarty to load, process and render the specified template. Once called no more actions
	* can be performed against the template (like variable assignments), so this should be the last order inside
	* an action.
	* @param string $template Name of the template, without extension
	*/
	public function render($template){
		
		self::$smarty->display($template.'.tpl');
	}
	
	/**
	* Include a PHP file as a template.
	*
	* In some certain cases (like when generating JSON files) it would be more suitable to render an action
	* against a PHP file directly. Use this method in those cases.
	* @param string $template Name of the PHP file, without extension
	*/
	public function render_plain($template){
		$file = 'templates/'.$template.'.php';
		
		if(file_exists($file)) require_once($file);
	}
	
	public function render_json($DATA){
		require_once('templates/output.json.php');
	}
	
	/**
	* Plugin loader.
	*
	* Useful for loading little pieces of code that you only need once in while.
	* Plugins are stored inside the 'plugins/' folder and have a .core9.php extension.
	* @param string $plugin Plugin name
	*/
	public function load_plugin($plugin){
		$path = 'plugins/'.$plugin.'.core9.php';
		
		if(file_exists($path)) require_once($path);
		else trigger_error('Core9: Plugin '.$plugin.' not found in /plugins/ folder.', E_USER_ERROR);
	}
	
	/**
	* Loads the language file.
	*
	* Language files are .ini files in which we define each string for our application. There must be one file
	* per language. This method must be called prior to using the config() method or loading language variables
	* from Smarty templates.
	* @param string $language Name of the language to load, in the form of two letters (es=Spanish, ca=Catalan, en=English)
	*/
	private function load_language($language){
		$path = 'lang/'.$language.'.lang.ini';
		
		if(file_exists($path)) self::$smarty->config_load('../'.$path);
		else trigger_error('The specificied language does not exist.', E_USER_ERROR);
	}
	
	/**
	* Retrieves values from a Smarty configuration file.
	*
	* This method is used to retrieve a value from a Smarty .ini file. This files can be used for a variety of
	* purposes and can be retrived from Smarty templates. This method allows to retrieve them also from PHP.
	* @param string $var Name of the configuration we want to read.
	* @param string $seccion Optional. Name of the section inside the .ini file where the configuration is stored.
	* @return string
	*/
	function config($var, $seccion=''){
		$value = self::$smarty->get_config_vars($var);
		
		return $value;
	}
}
	
?>
