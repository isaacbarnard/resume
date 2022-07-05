<?php namespace resume\models;

use resume\common\ResumeModel;

class Contacts extends ResumeModel {

    protected $table            = 'contacts';
    protected $primaryKey       = 'id';
    protected $returnType       = \resume\common\Entity::class;
    protected $allowedFields    = ['id','first_name','last_name','email'];

}

?> 