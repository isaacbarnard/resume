<?php namespace resume\common;

use \ArrayAccess;
use \IteratorAggregate;
use \ArrayIterator;
use \Countable;

class Entity implements ArrayAccess,IteratorAggregate,Countable  {

    protected $attributes   = [];
    protected $cast         = [];
    protected $changed      = false;


    public function __construct($data = null) {
        if(isset($data)){
            $this->fill($data);
        }
    }

    public function fill($data) {
        if(isAssoc($data)) {
            foreach ($data as $key => $value) {
                $this->attributes[$key] = $value;
            }
        }
    }

    public function hasChanged(): bool {
        return $this->changed;
    }

    public function &__get ($key) {
        $value = $this->attributes[$key];
        $value = $this->_setCast($key, $value);
        return $value;
    }

    public function __set($key,$value) {
        if(isset($this->attributes[$key])){
            $this->changed = true;
        }
        $this->attributes[$key] = $value;
    }

    public function __isset ($key) {
        return isset($this->attributes[$key]);
    }

    public function __unset($key) {
        unset($this->attributes[$key]);
    }

    public function offsetSet($offset,$value) {
        if (is_null($offset)) {
            $this->attributes[] = $value;
        } else {       
            if(isset($this->attributes[$offset])){
                $this->changed = true;
            }
            $this->attributes[$offset] = $value;     
        }
    }

    public function offsetExists($offset) {
        return isset($this->attributes[$offset]);
    }

    public function offsetUnset($offset) {
        if ($this->offsetExists($offset)) {
            unset($this->attributes[$offset]);
        }
    }

    public function offsetGet($offset) {
        $value = $this->offsetExists($offset) ? $this->attributes[$offset] : null;
        $value = $this->_setCast($offset, $value);
        return $value;
    }

    public function getIterator() {
        return new ArrayIterator($this->attributes);
    }

    public function count(): int {
      return count($this->attributes);
    }

    protected function _setCast($key, $value){
        if(array_key_exists($key, $this->cast)){
            settype($this->attributes[$key], $this->cast[$key]);
            return $this->attributes[$key];
        } else {
            return $value;
        }
    }  
}

?> 