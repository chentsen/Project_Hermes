<?php

class Application_Form_Registration extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
	public function __construct($options = null){
		parent::__construct($options);
		$this->setName('registration');
		$this->setAction('/registration/index');
		$this->setMethod('post');
		
		
		$nameValidator = new Zend_Validate_Regex(array('pattern'=>'/^[a-zA-Z\-\' ]+$/'));
		
		$email = new Zend_Form_Element_Text('email');
		$email->setRequired(true)
			  ->addValidator('EmailAddress');
			  
		$firstName = new Zend_Form_Element_Text('firstName');
		$firstName->setRequired(true)
				  ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true))
				  ->addValidator($nameValidator);
		
		$lastName = new Zend_Form_Element_Text('lastName');
		$lastName->setRequired(true)
				  ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true))
				  ->addValidator($nameValidator);
		
		$gender = new Zend_Form_Element_Select('gender');
		$gender->addMultiOptions(array('n'=>'Rather Not Say','m'=>'Male','f'=>'Female'));
		
		$city = new Zend_Form_Element_Text('city');
		$city->setRequired(true)
				  ->addValidator('StringLength',array('max'=>40,'allowWhiteSpace'=>true))
				  ->addValidator($nameValidator);
				  
		$password = new Zend_Form_Element_Password('password','password1');
		$password->addValidator('Regex',false,array('pattern' => '/^.*(?=.{6,20})(?=.*[\d])(?=.*[a-zA-Z])/'))
				 ->addValidator('StringLength',false,array('max'=>20))
				 ->setRequired(true);
		
		$password2 = new Zend_Form_Element_Password('password2');
		$password2->setRequired(true);
				  
		
			
		$register = new Zend_Form_Element_Submit('register');
		
		$this->addElements(array($firstName,$lastName,$email,$city,$password,$password2,$register,$gender));
		
		$this->setDecorators(array(
									array('ViewScript', 
										   array('viewScript' => '_form_registration.phtml'))  
								  )	 	
							);
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
		
	}
	public function addIdentical($postData){
		$this->password2->addValidator('Identical',false,array('token'=>$postData));
	}
}

