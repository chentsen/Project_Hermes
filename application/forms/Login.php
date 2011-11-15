<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
	
    }
    public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('login');
		$this->setAction('/index/index');
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
			  
		$password = new Zend_Form_Element_Password('password');
		$password->addValidator('Regex',false,array('pattern' => '/^.*(?=.{6,20})(?=.*[\d])(?=.*[a-zA-Z])/',
													'messages'=>array('regexNotMatch' => "Passwords must contain 6 to 20 characters and have at least one number")))
				 ->addValidator('StringLength',false,array('max'=>20))
				 ->setRequired(true)
				 ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A password is required.'
    					 )
  				  ))
				 ->removeDecorator('label')
				 ->removeDecorator('htmlTag');
		
    	
		$login = new Zend_Form_Element_Submit('login');
		$login->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper')
                                ->setLabel('Login');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_login.phtml'))));
		
		$this->addElements(array($email,$password,$login));
		$this->setElementDecorators(array('ViewHelper'),null,false);
    	/* Form Elements & Other Definitions Here ... */
    }


}

