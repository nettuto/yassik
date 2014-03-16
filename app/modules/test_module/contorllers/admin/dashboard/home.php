<?php

/**
 * 
 */
class Home extends BaseController {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		echo "i'm dashbord home under module/test_module/admin/dashboard!";
	}
}


