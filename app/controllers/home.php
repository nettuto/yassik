<?php


/**
 * 
 */
class Home extends BaseController {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		//echo "I'm a function from the home controller! <br/>";
		$this->view->load_view('home/index');
	}
	
	public function hello(){
		//echo "I'm a function from the home controller! <br/>";
		$this->view->load_view('home/hello');
	}
	
	
}
