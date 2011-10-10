<?php
class Application_Form_Contact extends Zend_Form{
	public function init(){
		
	}
	public function __construct($options = null){
		parent::__construct($options);
		$this->setName('contact');
		$this->setAction('index');
		$this->setMethod('POST');
		
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
                
                $name = new Zend_Form_Element_Text('name');
		$name->setRequired(true)
				  ->addValidator('StringLength',array('max'=>60,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				  		'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          					'regexNotMatch' => 'Please enter a valid name.'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A name is required.'
    					 )
  				  ));
                $subject = new Zend_Form_Element_Text('subject');
		$subject->setRequired(true)
				  ->addValidator('StringLength',array('max'=>60,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				  		'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          					'regexNotMatch' => 'Please enter a valid subject.'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A subject is required.'
    					 )
  				  ));
                
                $text = new Zend_Form_Element_Textarea('text',array("rows"=>10,'cols'=>50));
		$text->addValidator('StringLength',array('max'=>500,'allowWhiteSpace'=>true));
		
		$submit = new Zend_Form_Element_Submit('contact_submit',array('label' => 'Send'));
		
		
		$this->addElements(array($name, $text, $submit, $subject, $email));
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_contact.phtml'))));
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
	}
	
	
}