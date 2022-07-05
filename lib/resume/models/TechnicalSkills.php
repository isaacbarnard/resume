<?php namespace resume\models;

use resume\common\ResumeModel;

class TechnicalSkills extends ResumeModel {

    protected $table            = 'technical_skills';
    protected $primaryKey       = 'id';
    protected $returnType       = \resume\common\Entity::class;
    protected $allowedFields    = ['id','name', 'value'];

}

?> 