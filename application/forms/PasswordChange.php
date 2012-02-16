<?php

class Application_Form_PasswordChange extends Zend_Form
{

    public function init()
    {
	
    }
    public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('passwordReset');
		$this->setAction('/password-change/changepassword');
		$this->setMethod('post');
			  
		$pass = new Zend_Form_Element_Password('originalPassword');
		$pass->addValidator('Regex',false,array('pattern' => '/^.*(?=.{6,20})(?=.*[\d])(?=.*[a-zA-Z])/',
													'messages'=>array('regexNotMatch' => "Passwords must contain 6 to 20 characters and have at least one number")))
				 ->addValidator('StringLength',false,array('max'=>20))
				 ->setRequired(true)
				 ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'Original password is required.'
    					 )
  				  ))
				 ->removeDecorator('label')
				 ->removeDecorator('htmlTag');
				 
		$password = new Zend_Form_Element_Password('password');
		$password->addValidator('Regex',false,array('pattern' => '/^.*(?=.{6,20})(?=.*[\d])(?=.*[a-zA-Z])/',
													'messages'=>array('regexNotMatch' => "Passwords must contain 6 to 20 characters and have at least one number")))
				 ->addValidator('StringLength',false,array('max'=>20))
				 ->setRequired(true)
				 ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'New password required.'
    					 )
  				  ))
				 ->removeDecorator('label')
				 ->removeDecorator('htmlTag');
				 
		$password2 = new Zend_Form_Element_Password('password2');
		$password2->addValidator('Regex',false,array('pattern' => '/^.*(?=.{6,20})(?=.*[\d])(?=.*[a-zA-Z])/',
													'messages'=>array('regexNotMatch' => "Passwords must contain 6 to 20 characters and have at least one number")))
				 ->addValidator('StringLength',false,array('max'=>20))
				 ->setRequired(true)
				 ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'Retype your password.'
    					 )
  				  ))
				 ->removeDecorator('label')
				 ->removeDecorator('htmlTag');
		
    	
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->removeDecorator('submit')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper')
                                ->setLabel('Submit');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_passwordChange.phtml'))));
		
		$this->addElements(array($pass, $password, $password2,$submit));
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
    	/* Form Elements & Other Definitions Here ... */
    }


}

