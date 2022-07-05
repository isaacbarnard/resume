<?php namespace resume\models;

use resume\common\ResumeModel;

class Education extends ResumeModel {

    protected $table            = 'education';
    protected $primaryKey       = 'id';
    protected $returnType       = \resume\common\Entity::class;
    protected $allowedFields    = ['id','school_name'];

}

?> 