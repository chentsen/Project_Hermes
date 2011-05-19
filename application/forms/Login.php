<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
	
    }
    public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('login');
		$this->setAction('/login/login');
		$this->setMethod('post');
		$email = new Zend_Form_Element_Text('email');
		$email->setRequired(true)
			  ->removeDecorator('label')
			  ->removeDecorator('htmlTag');
		
		$password = new Zend_Form_Element_Password('password');
		$password->setRequired(true)
				 ->removeDecorator('label')
				 ->removeDecorator('htmlTag');
    	
		$login = new Zend_Form_Element_Submit('login');
		$login->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_login.phtml'))));
		
		$this->addElements(array($email,$password,$login));
    	/* Form Elements & Other Definitions Here ... */
    }


}

