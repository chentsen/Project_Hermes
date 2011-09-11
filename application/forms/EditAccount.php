<?php

class Application_Form_EditAccount extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
   public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('editAccount');
		$this->setAction('/accountedit/index');
		$this->setMethod('post');
                
		$firstName = new Zend_Form_Element_Text('firstName');
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
		
		$lastName = new Zend_Form_Element_Text('lastName');
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
                $city = new Zend_Form_Element_Text('city');
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
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_accountEdit.phtml'))));
		
		$this->addElements(array($submit, $firstName, $city, $lastName));
		$this->setElementDecorators(array('ViewHelper'),null,false);
                
    }
}