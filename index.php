<?php


$app_folder	    = 'app';
$core_folder	= 'core';

define('APPFOLDER', $app_folder.'/');
define('COREFOLDER', $core_folder.'/');

require 'core/yassik/Config.php';
require 'core/bootstrap.php';
require 'core/yassik/BaseController.php';
require 'core/yassik/BaseModel.php';
require 'core/yassik/BaseView.php';



$app = new Bootstrap();
