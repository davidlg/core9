<?php

class Controller{
	public $access = null;
	
	public $services = array('header', 'footer');
	
	public function __construct(){
		$this->security();
		
		if(isset($_GET['action'])) $method = $_GET['action'];
		else $method = $this->default_action;
		
		if(defined($this->common())) $this->common();
		
		$this->$method();
	}
	
	public function __call($method, $args){
		die('CORE9: unknown method '.$method);
	}
	
	private function security(){		
		if(isset($_SESSION['usuario'])){
			$usuario = unserialize($_SESSION['usuario']);
			
			if($this->access == 'admin' && $usuario->adm == 0){
				Core::render('core/error_403');
				exit();
			}
			
			if($usuario->get_log() == 0 && $_GET['mod'] != 'configuracion' && $_GET['mod'] != 'login'){
				Core::redirect('configuracion', 'index', '&force=1');
			}			
			
			Core::assign('usuario', $usuario);
		}elseif($this->access == 'private' || $this->access == 'admin'){
			Core::redirect('login', 'index', '&error=logout', '../');
		}
	}
	
	public function render($template){		
		Core::render($template);
	}
}

?>
