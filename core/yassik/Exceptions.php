<?php

/**
 * 
 */
class Exceptions {
	
	function __construct() {
		//echo "this is an error!!<br/>";
	}
	
	public function showException($exkind='', $exMessage='',$exTitle='')
	{
		
		$error = '';
		if($exTitle != ''){
			$error .= $exTitle.'<br/>';
		}
		
		if($exMessage != ''){
			$error .= $exMessage.'<br/>';
		}
		
		return $error;
	}
}
