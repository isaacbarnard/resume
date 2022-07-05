<?php namespace resume\models;

use resume\common\ResumeModel;

class WorkExperienceDetails extends ResumeModel {

    protected $table            = 'work_experience_details';
    protected $primaryKey       = 'id';
    protected $returnType       = \resume\common\Entity::class;
    protected $allowedFields    = ['id','description'];

}

?> 