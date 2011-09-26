<?php
class Application_Form_PersonalDescription extends Zend_Form{
	public function init(){
		
	}
	public function __construct($options = null){
		parent::__construct($options);
		$this->setName('personalDescription');
		$this->setAction('/profile/update-description');
		$this->setMethod('POST');
		$shortDescription = new Zend_Form_Element_Textarea('personalDescription_description',array("rows"=>3,'cols'=>50));
		$shortDescription->setRequired(true)
						 ->addValidator('StringLength',array('max'=>200,'allowWhiteSpace'=>true));
		$submit = new Zend_Form_Element_Submit('personalDescription_submit',array('label' => 'Update Profile'));
		$this->addElements(array($submit,$shortDescription));
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_personalDescription.phtml'))));
	}
	
}