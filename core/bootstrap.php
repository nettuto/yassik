<?php

/**
 * 
 */
class Bootstrap {
	
	
    private $_url = null;
    private $_controller = null;
    
	private $_appPath = APPFOLDER;
    private $_controllersPath = '';
    private $_modelsPath = '';
	private $_modulesPath = '';
	private $_config = '';
    private $_errorFile = 'error.php';
    private $_defaultFile = 'index.php';
	
	

	function __construct() {
		
		$this->_controllersPath = $this->_appPath . 'controllers/';
		$this->_modelsPath = $this->_appPath . 'models/';
		$this->_modulesPath = $this->_appPath . 'modules/';
		
		$this->_config = new Config();
		
		//echo $config->getConfigItem('language');
		
		$this->_getUrl();
		
		if(empty($this->_url[0])){
			$this->_loadDefaultController();	
			return FALSE;
		}
		
		$this->_loadController();
		
		
		
		
	}
	
	
	private function _getUrl()
	{
		//get request url and remove final backslash
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url,'/');
		$url = filter_var($url,FILTER_SANITIZE_URL);
		//explode the url to get sub sections
		$this->_url = explode('/', $url);
	}
	////'app/controllers/home.php';
	private function _loadDefaultController(){
		//SHOOLD WORK ON EXCEPTIONS!!!!!!!!!!!!!!!!!!
		require $this->_controllersPath . $this->_config->getConfigItem('default_controller').'.php';
		$arr = explode('/', $this->_config->getConfigItem('default_controller'));
		$cont = end($arr);
		$this->_controller = new $cont;
		$this->_controller->index();
		return FALSE;
		
	} 
	
	private function _error($kind,$title,$msg)
	{
		require COREFOLDER.'yassik/Exceptions.php';
		$this->_controller = new Exceptions();
		echo $this->_controller->showException($kind,$title,$msg);
		exit;
	}
	
	private function _loadController(){
		
		$file = null;
		//if _url[0] is a module!!
		if(is_dir(APPFOLDER.'modules/'.$this->_url[0]))
		{
			$last_folder_index = 0;
			//it's a module so build controllers path
			$cpath = APPFOLDER.'modules/'.$this->_url[0].'/contorllers/';
			//check if we have subfolders tree under controllers folder
			for($i=1; $i<(sizeof($this->_url)-1); $i++)
			{
				//if thers sub folder under controller path
				if(is_dir($cpath.$this->_url[$i]))
				{
					//build new controller path
					$cpath = $cpath.$this->_url[$i].'/';
					$last_folder_index = $i;
				}
			}
			
			$this->_controllersPath = $cpath;
			
			if(isset($this->_url[$last_folder_index+1]))
			{
				$file = $this->_controllersPath.$this->_url[$last_folder_index+1].'.php';	
			}
			else
			{
				$this->_error(0, 'Controller Error!', 'No controller is given! please check your URL.');
			}
			
			
		}
		else//if _url[0] is not a module!! so it's a controller or a subfolder of a controllers 
		{
			$last_folder_index = 0;
			$cpath = '';
			//check if _url[$i] is a subfolder of controllers!!
			for($i=0; $i<sizeof($this->_url);$i++)
			{
					
				if(is_dir($this->_controllersPath.$this->_url[$i]))
				{
					$last_folder_index = $i;
					$this->_controllersPath = $this->_controllersPath.$this->_url[$i].'/';
					echo $i;
				}
					
			}
			
			if($last_folder_index!=0){
				
				if(isset($this->_url[$last_folder_index+1]))
				{
					$file = $this->_controllersPath.$this->_url[$last_folder_index+1].'.php';	
				}
				else
				{
					$this->_error(0, 'Controller Error!', 'No controller is given! please check your URL.');
				}
				
				
			}
			else
			{
				$file = $this->_controllersPath.$this->_url[0].'.php';	
			}
			
			
			
			
			
		}
				
		if (file_exists($file)) 
			{
				require $file;
				$controller_index = 0;
				if($last_folder_index!=0)
				{
					$controller_index = $last_folder_index+1;	
					$this->_controller = new $this->_url[$controller_index];
					
					//check if there a method passed on url
					if(isset($this->_url[$controller_index+1])){
						
						if(function_exists($this->_url[$controller_index+1])){
							$this->_controller->{$this->_url[$controller_index+1]}();
						}
						else
						{
							$this->_error(1, 'Method Error', 'No valid method given');	
						}
						
					}
					else//load index method 
					{
						$this->_controller->index();
					}
				}
				else
				{
					
					$this->_controller = new $this->_url[$controller_index];
					//check if the method given on _url exists and call it if it is!
					if(function_exists($this->_url[1])){
						//$this->_controller->{$this->_url[$controller_index+1]}();
					}
					else
					{
						$this->_error(1, 'Method Error', 'No valid method given');	
					}
					//$this->_controller->index();
				}
			}
			else
			{
				//echo "error loading controller";
				//$controller = new Exceptions();
				$this->_error('', 'Controller File Error', 'Controller File '.$file.' dosnt Exist!');
				return FALSE;
			}
		
		
		//----------------------------------------------------------------	
		//if we call a module!	
	/*	if(is_dir(APPFOLDER.'modules/'.$this->_url[0]))
		{
			echo 'module';
			//we change the controller path by appending module name!
			$this->_controllersPath = $this->_modulesPath .$this->_url[0].'/controllers/';
		}
			
		$file = $this->_controllersPath.$this->_url[0].'.php';
		
		
/*			
		//check if first arg is a module
		
		if(is_dir('app/modules/'.$this->_url[0])){
			echo "yes i'm a module! ".'app/modules/'.$this->_url[0];
		}else{
			
			echo "hey i'm a controller!<br />";
			
			$file = 'app/controllers/'.$this->_url[0].'.php';
			
			if (file_exists($file)) {
				require $file;
			}else{
				require 'core/yassik/Exceptions.php';
				$controller = new Exceptions();
				return FALSE;
			}
			
			$this->_controller = new $this->_url[0];
			
			if(isset($this->_url[2])){
				$this->_controller->{$this->_url[1]}($this->_url[2]);
			}else{
				if(isset($this->_url[1])){
					$this->_controller->{$this->_url[1]}();
				}else{
					$this->_controller->index();
				}
			}
			
		}
		
		
		*/
		
		
		
	}
	
	
	
}
