<?php

/**
 * 
 */
class BaseView {
	
	function __construct() {
		
	}
	
	
	public function load_view($view){
		require 'app/views/'.$view.'.php';
	}
	
}
