<?php namespace resume\common;

use resume\common\Element;

class Layout {

    protected $doc;

    public $head;
    public $body;
    public $foot;
    
    public $title;

    public function __construct() {
        $this->default();
    }

    public function default() {

        $this->title = 'Resume';

        $this->doc = new Element('html');

        $this->head = new Element('head');
        $this->body = new Element('body');
        $this->foot = new Element();

        $this->head->add(view('head'));
        $this->foot->add(view('foot'));
    }

    public function draw($echo = true) {

        $this->head->add(new Element('title', $this->title));

        $this->doc->append($this->head);
        $this->doc->append($this->body);
        $this->doc->append($this->foot);

        if($echo) {
            echo '<!DOCTYPE html>'.$this->doc->build();
        } else {
            return '<!DOCTYPE html>'.$this->doc->build();
        }
    }

}

?> 