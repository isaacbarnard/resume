<?php namespace resume\models;

use resume\common\ResumeModel;

class WorkExperience extends ResumeModel {

    protected $table            = 'work_experience';
    protected $primaryKey       = 'id';
    protected $returnType       = \resume\common\Entity::class;
    protected $allowedFields    = ['id','job_title', 'company_name'];

}

?> 