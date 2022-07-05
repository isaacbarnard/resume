<?php namespace resume\controllers;

use resume\common\Controller;
use resume\models\Contacts;
use resume\models\TechnicalSkills;
use resume\models\Styles;
use resume\models\Education;
use resume\models\WorkExperience;
use resume\models\WorkExperienceDetails;

class Home extends Controller {

    public function index(array $id) {
	$this->layout->title = 'Resume';

	$email 	= 'ibarnard89@gmail.com';
	$view 	= 'resume';
	$data 	= $this->_getResumeData($email);

	echo view($view, $data);
    }

    private function _getResumeData($email = null): array {
    	if(!isset($email)) { return; }

    	$email = (string) $email;
    	$contactId;

	$modelContacts 			= new Contacts();
	$modelStyles 			= new Styles();
    	$modelTechnicalSkills		= new TechnicalSkills();
    	$modelEducation			= new Education();
    	$modelWorkExprience		= new WorkExperience();
    	$modelWorkExperienceDetails	= new WorkExperienceDetails();

	$dataContacts			= \resume\common\Entity::class;
	$dataContactInfo		= \resume\common\Entity::class;
	$dataStyles			= \resume\common\Entity::class;
	$dadaTechnicalSkills		= \resume\common\Entity::class;
    	$dataEducation			= \resume\common\Entity::class;
	$dataWorkExprience		= \resume\common\Entity::class;
	$dataWorkExperienceDetails	= \resume\common\Entity::class;

	$modelContacts->search('WHERE email=\'' . $email . '\'');
	$dataContacts = $modelContacts->selectAll();
	$modelContacts->columns('
		email,
		phone,
		CONCAT(city,\', \',province) as address,
		github
	');
	$dataContactInfo = $modelContacts->selectAll();

	if (count($dataContacts) === 0) { return; }

	$contactId = $dataContacts[0]['id'];

	$modelStyles->search('WHERE contact_id=' . $contactId);
	$dataStyles = $modelStyles->selectAll();

	$modelTechnicalSkills->search('WHERE contact_id=' . $contactId);
	$dadaTechnicalSkills = $modelTechnicalSkills->selectAll();

	$modelEducation->order(['end_year' => 'ASC']);
	$modelEducation->search('WHERE contact_id=' . $contactId);
	$dataEducation = $modelEducation->selectAll();

	$modelWorkExprience->order(['end_year' => 'ASC']);
	$modelWorkExprience->search('WHERE contact_id=' . $contactId);
	$dataWorkExprience = $modelWorkExprience->selectAll();

	$workExprienceDetailsIds;
	if(is_array($dataWorkExprience)){
		$temp = [];
		foreach($dataWorkExprience as $r) {
			$temp[] = $r['id'];
		}
		$workExprienceDetailsIds = implode(',', $temp);
	} else {
		$workExprienceDetailsIds = $dataWorkExprience[0]['id'];
	}
	$modelWorkExperienceDetails->search('WHERE work_experience_id in (' . $workExprienceDetailsIds . ')');
	$dataWorkExperienceDetails = $modelWorkExperienceDetails->selectAll();

	return array (
		'Contacts' 		=> $dataContacts[0],
		'ContactInfo'		=> $dataContactInfo[0],
		'Styles' 		=> $dataStyles[0],
		'TechnicalSkills'	=> $dadaTechnicalSkills,		
		'Education'		=> $dataEducation,			
		'WorkExperience' 	=> $dataWorkExprience,
		'WorkExperienceDetails' => $dataWorkExperienceDetails
	);
    }    
}

?> 
