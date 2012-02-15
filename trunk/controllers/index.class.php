<?php

class IndexController extends Controller{
	public $access = 'public';
	public $default_action = 'index';
	
	public function common(){
		
	}
	
	public function index(){
		Core::render("index/index");
	}
}

?>
