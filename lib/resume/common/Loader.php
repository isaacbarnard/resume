<?php namespace resume\common;

class Loader {

	public static $data;

	function object($input) {
		self::$data = (object)array_merge((array)self::$data, (array)$input);
	}

	function view($viewName, $input = null): string {
		$file = __VIEWDIR__ . '/' . $viewName . '.php';
	    if (is_file($file)) {
	        ob_start();
        	extract((array)($input ? $input : self::$data));
	        include $file;
	        return ob_get_clean();
	    }
	}

}

?> 