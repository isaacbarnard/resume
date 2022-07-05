<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

define('__NAMESPACEROOT__', 	'resume');
define('__HOMEPAGE__', 		'Home');
define('__DIRROOT__', 		'/var/www/resume.wwdev.ca/');
define('__IMAGEDIR__', 		__DIRROOT__ . 'public/assets/images/');
define('__VIEWDIR__', 		__DIRROOT__ . 'view');
define('__CONTROLLERPATH__', 	__NAMESPACEROOT__ . '\\controllers\\');

require_once(__DIR__ . '/helper.php');

spl_autoload_extensions(".php");
spl_autoload_register(function($class){
	$file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) { include_once($file); }
});

?>
