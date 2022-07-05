<?php namespace resume\routing;

use resume\routing\Request;
use resume\common\Loader;
use resume\common\Layout;

class Router {

	protected $request;

    public $routes = [];
    public $whitelist;
    public $NotFound;

    public function __construct($whitelist, $NotFound) {
    	$this->request = new Request();
    	$this->whitelist = $whitelist;
    	$this->NotFound = $NotFound;
    }
    
    public function route() {
    	$c = $this->getController();
        ob_clean();
        ob_start();
        $c->remap($this->request);

        $data = ob_get_clean();

        switch ($c->type) {
            case 'html':
                $this->routeHtml($c, $data);
                break;
            case 'json':
                $this->routeJson($data);
                break;
        }
    }

    protected function routeHtml($c, $data) {
        ob_start();
        header('Content-Type: text/html');

        if($c->layout) {
            $c->layout->body->add($data);
            $c->layout->draw(true);
        } else {
            echo $data;
        }
    }

    protected function routeJson($data) {
        ob_start();
        header('Content-Type: application/json');
        echo $data;
    }

    protected function getController() {
    	$controller = $this->getRoute();

        $c = new $controller();
        $c->load = new Loader();
        $c->layout = new layout();
        $c->type = 'html';

    	return $c;
    }

    protected function getRoute() {
    	$controller = ucfirst($this->request->controller);

    	if(!$this->whitelist) { 
            if($controller == '' || !class_exists(__CONTROLLERPATH__ . $controller)) {
                return __CONTROLLERPATH__ . __HOMEPAGE__;
            }

            return __CONTROLLERPATH__ . $controller;
        }

    	if(isset($this->routes[$controller])) { 
            return __CONTROLLERPATH__ . $this->routes[$controller];  
        }

    	return __CONTROLLERPATH__ . $this->NotFound;
    }  

}

?> 