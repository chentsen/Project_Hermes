<?php

class Application_Form_PasswordReset extends Zend_Form
{

    public function init()
    {
	
    }
    public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('passwordReset');
		$this->setAction('/password-reset/resetpassword');
		$this->setMethod('post');
			  
    	$email = new Zend_Form_Element_Text('email');
		$email->setRequired(true)
			  ->addValidator('EmailAddress',true, array(
     			'messages' => array(
          			'emailAddressInvalidFormat' => 'Please enter a valid email address. EX: jane@emailaddress.com'
    			 )))
			  ->addValidator('NotEmpty', true, array(
     			'messages' => array(
          			'isEmpty' => 'An email address is required.'
    			 )
  				));
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->removeDecorator('submit')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper')
                                ->setLabel('Submit');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_passwordReset.phtml'))));
		
		$this->addElements(array($email,$submit));
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
    	/* Form Elements & Other Definitions Here ... */
    }


}

