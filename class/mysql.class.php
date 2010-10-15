<?php

/**
* Wrapper MySQL modificado para el Visor.
*
* Wrapper estándard del Core9 para MySQL modificado para cumplir los requisitos del Visor.
* @author Miquel Àngel Moya <miquelm@limit.es>
* @version 10.09.10
* @license LGPL
* @package Visor
* @subpackage Extras
**/

/**
* Clase de conexión a MySQL de Core9 modificada.
* 
* Provee la misma funcionalidad que la clase MySQL de Core9 pero modificada para permitir conexiones simultáneas
* a diferentes esquemas en la misma o diferente base de datos.
* @author Miquel Àngel Moya <miquelm@limit.es>
* @version 10.09.10
* @license LGPL
* @package Visor
* @subpackage Extras
**/
class MySQL{
	/**
	* Resource de MySQL usado entre métodos de la clase
	* @var object
	**/
	protected $dbi;
	
	/**
	* Resultado de la consulta SQL en forma de array
	* @var array
	**/
	public $resultado;
	
	/**
	* Constructor de la clase. Ejecuta la consulta pasada por argumento en la base de datos indicada.
	* Las bases de datos se especifican en el fichero config.inc.php.
	* @param string $sql Sentencia SQL a ejecutar
	* @param string $conn Conexión a base de datos a usar, definidas en config.inc.php
	* @see config/config.inc.php
	**/
	public function __construct($sql, $conn='g7'){
		global $MYSQL;
		
		$host = $MYSQL[$conn]['host'];
		$user = $MYSQL[$conn]['user'];
		$pass = $MYSQL[$conn]['password'];
		$db = $MYSQL[$conn]['db'];
		
		if(!empty($sql)){		
			$this->dbi = mysql_connect($host, $user, $pass) or die(mysql_error());
			mysql_select_db($db, $this->dbi) or die(mysql_error());
			
			//Estableciendo el cotejamiento de carácteres para las consultas MySQL
			$this->set_collate();
			
			$q = mysql_query($sql, $this->dbi) or die(mysql_error().': '.$sql);
			
			if(!is_bool($q)){
				if(mysql_num_rows($q) > 0){
					while($row = mysql_fetch_array($q)){
						$this->resultado[] = $row;
					}
				}else $this->resultado = null;
			}
		}
	}
	
	/**
	* Establece el cotejamiento de carácteres que se usará durante la conexión MySQL.
	*
	* Por defecto se usará UTF-8. Los cotejamientos se definen en el fichero de configuración junto al resto
	* de parámetros de conexión.
	* @see config/config.inc.php
	* @uses DBA_COLLATE Cotejamiento de carácteres para la conexión. Por defecto UTF-8.
	**/
	private function set_collate(){
		mysql_query("SET CHARACTER SET '".DBA_COLLATE."'", $this->dbi) or die($this->error(mysql_error($this->dbi)));
	}
}

?>
