<?php

use resume\common\Controller;
use resume\common\Loader;

if (!function_exists('view')) {
	function view($viewName, $input = null): string {
		$l = new Loader();
		return $l->view($viewName, $input);
	}
}

if (!function_exists('load')) {
	function load($input) {
		$l = new Loader();
		return $l->object($input);
	}
}

if (!function_exists('loadSvg')) {
	function loadSvg($input) {
		$path = __IMAGEDIR__ . $input .'.svg';
		if(is_file($path)) { include($path); }		
	}
}

if (!function_exists('isAssoc')) {
	function isAssoc($arr): bool {
	    if (array() === $arr) return false;
	    return array_keys((array)$arr) !== range(0, count((array)$arr) - 1);
	}
}

if (!function_exists('printVarName')) {
	function printVarName($var): string {
	    foreach($GLOBALS as $varName => $value) {
	        if ($value === $var) {
	            return $varName;
	        }
	    }
	    return false;
	}
}

if (!function_exists('strLreplace')) {
	function strLreplace($search, $replace, $subject): string {
	    $pos = strrpos($subject, $search);
	    
	    if($pos !== false) {
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
	    }

	    return $subject;
	}
}

if (!function_exists('createObjectVars')) {
	function createObjectVars($object, array $vars) {		
        foreach($vars as $key => $value) {
            $object->$key = $value;
        }
	}
}

if (!function_exists('setObjectVars')) {
	function setObjectVars($object, array $vars) {
	    $has = get_object_vars($object);
	    foreach ($has as $name => $oldValue) {
	        $object->$name = isset($vars[$name]) ? $vars[$name] : NULL;
	    }
	}
}

if (!function_exists('getObjectPublicVars')) {
	function getObjectPublicVars($object) {
	    return get_object_vars($object);
	}
}

if (!function_exists('guidv4')) {
	function guidv4($data = null) {

	    $data = $data ?? random_bytes(16);
	    assert(strlen($data) == 16);

	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
	    
	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
}

?> 