<?php

/**
* Núcleo del Core9 Framework.
*
* Este es el corazón del sistema y donde arranca todo.
* @author Miguel Ángel Moya <admin@nirvash.org>
* @version 10.07.001
* @copyright 2009-2010 Estudio Vakadas
* @link http://www.vakadas.com
* @license LGPL
* @package Core9
**/

/**
* Función que usa el Magic __autoload() para cargar automáticamente todas las clases que se soliciten.
* @param string $class_name Nombre de la clase a cargar.
**/
function __autoload($class_name){
	$path = 'class/'.strtolower($class_name).'.class.php';
	
	if(file_exists($path) && $class_name != "Core"){
		/**
		* Incluye la clase solicitada en $class_name.
		* @see __autoload()
		**/
		require_once $path;
	}
}

/**
* Clase principal del núcleo.
*
* Se inicializan los parámetros generales de la aplicación y se pone en marcha todo.
* @author Miguel Ángel Moya <admin@nirvash.org>
* @version 10.07.001
* @copyright 2009-2010 Estudio Vakadas
* @link http://www.vakadas.com
* @license LGPL
* @package Core9
**/
class Core extends Smarty{
	/**
	* Último mensaje de error generado por la aplicación.
	* @var string
	**/
	public $error;
	
	/**
	* Último mensaje de debug generado por la aplicación.
	* @var string
	**/
	public $debug;
	
	/**
	* Inicialización de la clase.
	*
	* Principalmente se arranca el motor Smarty y se aplica la configuración correspondiente.
	**/
	public function __construct(){
		$this->debug('CORE9: Arrancando el núcleo.');
				
		//Arrancando Smarty
		$this->debug('CORE9: Arrancando motor de plantillas Smarty.');
		$this->Smarty();
		
		//Configuración de Smarty
		$this->template_dir = getcwd().'/html/';
		$this->compile_dir = getcwd().'/templates_c/';
		$this->config_dir = getcwd().'/config/';
		$this->cache_dir = getcwd().'/cache/';
		$this->caching = false;
				
		$this->debug('CORE9: El núcleo está arrancado y corriendo.');
	}
	
	public function plugin_load($plugin){
		$path = 'plugins/'.$plugin.'.core9.php';
		
		if(file_exists($path)) require_once($path);
		else $this->error('Plugin no encontrado: '.$plugin);
	}
	
	/**
	* Muestra el código de un fichero PHP con coloreado de código.
	*
	* Útil para hacer debug cuando algo sale mal.
	* @param string $fichero Fichero del que se quiere ver el código fuente.
	* @return string
	**/
	public function codigo($fichero){
		ob_start();

		$this->debug('Se ha solicitado el código fuente del fichero <i>'.$fichero.'</i>.');
		if(file_exists(urldecode($fichero))){
			$this->debug('Cargando código fuente del fichero <i>'.$fichero.'</i>.');
			highlight_file(urldecode($fichero));
			$resultado = ob_get_contents();
		}else{
			$this->debug('No puedo encontrar el fichero <i>'.$fichero.'</i>. Saliendo.', 1);
			$this->errorpage('404');
			exit();
		}
		
		ob_end_clean();
		
		return $resultado;
	}
	
	/**
	* Registro de debug.
	*
	* Esta función se llama desde diversas partes de Core9 para añadir información de debug que luego puede
	* ser útil para localizar fallos y solucionarlos.
	* @param string $mensaje Mensaje de debug a insertar.
	* @param boolean $error Indica si el mensaje es un error o información simple.
	**/
	public function debug($mensaje, $error=0){
		if($error){
			$this->debug .= "<strong>";
			$mensaje = "ERROR: ".$mensaje;
		}
		$this->debug .= '#'.date('d/m/Y H:i:s').'# '.$mensaje.'<br />';
		if($error) $this->debug .= "</strong>";
	}
	
	/**
	* Genera un error crítico y finaliza el núcleo.
	*
	* Esta función se llama cuando ocurre un error grave que no permite al núcleo seguir corriendo, como por ejemplo
	* un fichero que no existe o una configuración incorrecta.
	* @param string $mensaje Mensaje de error que se mostrará al usuario.
	**/
	public function error($mensaje){
		$this->assign('error', $mensaje);
		$this->assign('debug', $this->debug);
		$this->display('error/core.tpl');
		
		exit();
	}
	
	/**
	* Generador de páginas de errores.
	*
	* Esta función carga una página de error, según el código de error facilitado. Las páginas de error se almacenan
	* junto a las demás plantillas, en /html/error/.
	* @param mixed $codigo Código de error y nombre de la plantilla.
	**/
	public function errorpage($codigo){
		$this->debug('CORE9: Ejecución detenida. Error '.$codigo.'.');
		
		$ruta_tpl = 'error/'.$codigo.'.tpl';
		
		//Información de debug
		$this->assign('debug', $this->debug);
		
		if(!file_exists('html/'.$ruta_tpl)) $this->error('Error al cargar la página de error!!');
		else $this->display($ruta_tpl);
		
		$this->debug('CORE9: Detención del núcleo solicitada.', 1);
	}
	
	/**
	* Alias de get_config_vars(), una función de Smarty.
	*
	* Se usa para recuperar información de ficheros .ini.
	* @param string $var Nombre de la variable (configuración) que se quiere leer.
	* @param string $seccion Opcional. Nombre de la sección dentro del fichero .ini donde se sitúa la configuración.
	* @return string
	**/
	function config($var, $seccion=''){
		return $this->get_config_vars($var, $seccion);
	}
	
	/**
	* Destructor del núcleo.
	* 
	* A parte de informar de que la ejecución ha terminado, no hace mucha cosa más. Tal vez más adelante.
	**/
	public function __destruct(){
		$this->debug('CORE9: El núcleo está parado.');
	}
}
	
?>
