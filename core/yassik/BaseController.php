<?php

/**
 * 
 */
class BaseController {
	
	function __construct() {
		//echo "I'm the main controller!<br />";
		$this->view = new BaseView();
	}
}
