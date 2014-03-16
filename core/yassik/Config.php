<?php

/**
 * 
 */
class Config {
		
	private $_config = array();
	
	function __construct() 
	{
		
		$this->_loadConfigFile();
	}
	
	private function _loadConfigFile()
	{
		
		if ( ! file_exists(APPFOLDER.'config/config.php'))
		{
			exit('The configuration file does not exist.');
		}
		else
		{
			require(APPFOLDER.'config/config.php');
			if ( ! isset($config) OR ! is_array($config))
			{
				exit('Your config file does not appear to be formatted correctly.');
			}
			else
			{
				$this->_config = $config;
			}
		}
		
	}
	
	public function getConfigItem($item, $index='')
	{
		if ($index == '')
		{
			if ( ! isset($this->_config[$item]))
			{
				return FALSE;
			}

			$res = $this->_config[$item];
		}
		else
		{
			if ( ! isset($this->config[$index]))
			{
				return FALSE;
			}

			if ( ! isset($this->config[$index][$item]))
			{
				return FALSE;
			}
			
			$res = $this->config[$index][$item];
		}
		
		return $res;
		
	}
	
	
	
	
	
	
}
