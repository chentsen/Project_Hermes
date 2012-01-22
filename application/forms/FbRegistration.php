<?php

class Application_Form_FbRegistration extends Zend_Form
{

    public function init()
    {
        /* specialized registration form only shows what is missing. */
    }
	public function __construct($options = null){
                parent::__construct($options);
		$this->setName('registration');
                $this->setAction('/registration/fb-retry');
		$this->setMethod('post');
		
		
		$nameValidator = new Zend_Validate_Regex(array('pattern'=>'/^[a-zA-Z\-\' ]+$/','messages'=>
				array('regexNotMatch'=>"NOT MATCH")));
               
		if(!$options['email']){
		    $email = new Zend_Form_Element_Text('email');
		}else{
		    $email = new Zend_Form_Element_Hidden('email');
		    $email->setValue($options['email']);
		}
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
		
  		if(!$options['betakey']){
		    $betakey = new Zend_Form_Element_Text('betakey');
		}else{
		    $betakey = new Zend_Form_Element_Hidden('betakey');
		    $betakey->setValue($options['betakey']);
		}
		$betakey->setRequired(true)
				->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'Please enter a beta key'
    					 )
  				  ));
             
			  
		if(!$options['firstName']){
		    $firstName = new Zend_Form_Element_Text('firstName');
		}else{
		    $firstName = new Zend_Form_Element_Hidden('firstName');
		    $firstName->setValue($options['firstName']);
		}
		$firstName->setRequired(true)
				  ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				  		'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          					'regexNotMatch' => 'Please enter a valid firstname.'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A firstname is required.'
    					 )
  				  ));
		
		if(!$options['lastName']){
		    $lastName = new Zend_Form_Element_Text('lastName');
		}else{
		    $lastName = new Zend_Form_Element_Hidden('lastName');
		    $lastName->setValue($options['lastName']);
		}
		$lastName->setRequired(true)
				  ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				 		 'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          				'regexNotMatch' => 'Please enter a valid lastname'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A lastname is required.'
    					 )
  				  ));
		if(!$options['gender']){
		    $gender = new Zend_Form_Element_Select('gender');
		    $gender->addMultiOptions(array('n'=>'Rather Not Say','m'=>'Male','f'=>'Female'));
		}else{
		    $gender = new Zend_Form_Element_Hidden('gender');
		    $gender->setValue($options['gender']);
		}
		
		
		
		
		if(!$options['city']){
		    $city = new Zend_Form_Element_Text('city');
		}else{
		    $city = new Zend_Form_Element_Hidden('city');
		    $city->setValue($options['city']);
		}
		$city->setRequired(true)
				  ->addValidator('StringLength',array('max'=>40,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				 	    'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          				'regexNotMatch' => 'Please enter a valid city name.'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A city is required.'
    					 )
  				  ));
			
		$register = new Zend_Form_Element_Submit('register');
		$register->removeDecorator('DtDdWrapper')
                        ->setLabel('Register');
		
		$this->addElements(array($firstName,$lastName,$email,$city,$password,$password2,$register,$gender,$betakey));
		
		$this->setDecorators(array(
									array('ViewScript', 
										   array('viewScript' => '_form_fb_registration.phtml'))  
								  )	 	
							);
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
		
	}
	
}

