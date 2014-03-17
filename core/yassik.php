<?php

define('APPFOLDER', $app_folder.'/');
define('COREFOLDER', $core_folder.'/');

require 'yassik/Config.php';
require 'yassik/bootstrap.php';
require 'yassik/BaseController.php';
require 'yassik/BaseModel.php';
require 'yassik/BaseView.php';



$app = new Bootstrap();

