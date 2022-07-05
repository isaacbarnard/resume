<?php namespace resume\common;

class Controller { 

	public $load;
	public $layout;
	public $type;

    public function remap($r): bool {
    	$location = $r->location;

    	$r->location = (method_exists($this, $r->location) ? $r->location : 'index');

		$ref = new \ReflectionMethod($this, $r->location);		
    	$r->location = ($ref->isPublic() ? $r->location : 'index');

    	if($location != '' && $r->location == 'index') {
    		array_unshift($r->parameters, $location);
    	}

        if (!class_exists(__CONTROLLERPATH__ . ucfirst($r->controller))) {
    		array_unshift($r->parameters, $r->controller);
        }

    	if(method_exists($this, $r->location)) {
			call_user_func_array(array($this, $r->location), $this->_formatArgs($r));
			return true;
    	}

		return false;
    }

    private function _formatArgs($r): array {
    	if(method_exists($this, $r->location)) {

			$ref = new \ReflectionMethod($this, $r->location);
			$params = $ref->getParameters();
			$pCount = sizeof($params);

			if($pCount == 0) { return $r->parameters; }

			$aCount = sizeof($r->parameters);

			if($aCount > $pCount && $params[$pCount-1]->getType() == 'array') {

				$temp = array_slice($r->parameters, 0, $pCount-1);
    			$temp[] = array_slice($r->parameters, $pCount-1);

    			$r->parameters = $temp;
			}

			for ($i = 0; $i < $pCount; $i++) {

				$t = $params[$i]->getType();

				if($t) {
					if($i < $aCount) {
						settype($r->parameters[$i], $t);
					} else {
						$empty = NULL;
						settype($empty, $t);
						$r->parameters[] = $empty;						
					}				
				} else {
					if($i > $aCount-1) {
						$r->parameters[] = '';
					}
				}
			} 
    	}

		return $r->parameters;
    }
    
}

?> 