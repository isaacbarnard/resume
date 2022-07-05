<?php namespace resume\common;

class Element {

    public $tag = '';
    public $parameters = [];
    public $content = [];

    protected $voidElements = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr'
    ];

    public function __construct($tag = '', $content = null, $parameters = []) {
        $this->tag = $tag;
        $this->parameters = $parameters;
        if($content){
            if($this->isVoid() && !$parameters){
                $this->parameters = $content;
            } else {
                array_push($this->content, $content);
            }
        }
    }

    public function add($content) {        
        array_unshift($this->content, $content);
    }

    public function append($content) {
        array_push($this->content, $content);
    }

    public function params($parameters) {
        if($this->parameters){
            $this->parameters = array_merge($this->parameters, $parameters);
        } else {
            $this->parameters = $parameters;
        }
    }

    public function build($echo = false): string {
        $html = $this->validate();

        if($echo) {
            echo $html; 
        } else {
            return $html;
        }
    }

    protected function formatParams(): string{
        $html = '';
        if($this->parameters) {
            foreach ($this->parameters as $key => $value) {
                $html .= $key.'="'.$value.'" ';
            }
        }
        return $html;
    }

    protected function getTag($close = false): string {
        if($this->tag){
            if($close) {
                return '</'.$this->tag.'>';
            } else {
                return '<'.$this->tag.' '.$this->formatParams().'>';
            }
        }
        return '';
    }

    protected function validate(): string {
        return ($this->isVoid() ? $this->void() : $this->standard());
    }

    protected function isVoid(): int {
        return in_array($this->tag, $this->voidElements);
    }

    protected function standard(): string {
        $html = $this->getTag();

        foreach($this->content as $c) {
            $html .= ($c instanceof Element ? $c->build() : $c);
        }

        $html .= $this->getTag(true);
        return $html;
    }

    protected function void(): string {
        $html = rtrim($this->getTag(), '>').'/>';
        return $html;
    }

}

?> 