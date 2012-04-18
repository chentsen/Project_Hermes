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
		$this->setAction('/account-edit/updateaccount');
		$this->setMethod('post');
                
		$firstName = new Zend_Form_Element_Text('firstName');
		$firstName->setRequired(true)
                        ->setValue($options['firstName'])
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
                        ->setValue($options['lastName'])
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
		$gender = new Zend_Form_Element_Select('gender');
		$gender->addMultiOptions(array('n'=>'Rather Not Say','m'=>'Male','f'=>'Female'))
				->setValue($options['gender']);
				
				
                $city = new Zend_Form_Element_Text('city');
		$city->setRequired(true)
                                ->setValue($options['city'])
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
		$hasEmailPerm = new Zend_Form_Element_Checkbox('hasEmailPerm');
		$hasEmailPerm->setRequired(false)
					->setValue($options['hasEmailPerm']);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper')
                                ->setLabel('Submit');
		$description= new Zend_Form_Element_Textarea('description',array("rows"=>3));
		$description->setRequired(true)->addValidator('StringLength',array('max'=>200,'allowWhiteSpace'=>true))->setValue($options['description']);
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_accountEdit.phtml'))));
		
		$this->addElements(array($submit,  $hasEmailPerm, $gender, $firstName, $city, $lastName,$description));
		$this->setElementDecorators(array('ViewHelper'),null,false);
                
                
            
    }
}