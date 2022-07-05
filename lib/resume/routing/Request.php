<?php namespace resume\routing;

class Request {

    public $fullpath = '';
    public $controller = '';
    public $location = '';
    public $parameters = [];

    public function __construct() {
        if(is_null($_GET['q'])) { return; }

        $this->fullpath = $_GET['q'];
        $request = preg_split('@/@', $_GET['q'], NULL, PREG_SPLIT_NO_EMPTY);

        if(!isset($request)) { return; }

        $this->controller = strtolower((count($request) > 0 ? array_shift($request) : ''));
        $this->location = strtolower((count($request) > 0 ? array_shift($request) : ''));
        $this->parameters = $request;
    }
}
?> 