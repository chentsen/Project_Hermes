<?php
class Application_Form_ProfilePic extends Zend_Form{
	public function init(){
		
	}
	public function __construct($options=null){
		parent::__construct($options);
		$this->setName('profilePic');
		$this->setAction('/account-edit/upload-pic');
		$this->setMethod('POST');
		$image = new Zend_Form_Element_File('image');
		$image->removeDecorator('label')
		      ->setRequired(true)
		      ->setMaxFileSize(2097152); // limits the filesize on the client side
		      //->setDescription('Click Browse and click on the image file you would like to upload');
		$image->addValidator('Count', false, 1);                // ensure only 1 file
		$image->addValidator('Size', false, 2097152);            // limit to 10 meg
		$image->addValidator('Extension', false, 'jpg,jpeg,png,gif');// only JPEG, PNG, and GIFs
		$submit = new Zend_Form_Element_Submit('profilePic_submit',array('label' => 'Upload'));
		$this->addElements(array($submit,$image));
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_profilePic.phtml'))));
	}
}