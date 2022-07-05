<?php namespace resume\models;

use resume\common\ResumeModel;

class Styles extends ResumeModel {

    protected $table            = 'styles';
    protected $primaryKey       = 'id';
    protected $returnType       = \resume\common\Entity::class;
    protected $allowedFields    = ['id','color'];

}

?> 