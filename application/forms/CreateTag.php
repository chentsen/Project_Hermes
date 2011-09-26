<?php

class Application_Form_CreateTag extends Zend_Form
{

    public function init()
    {
	
    }
    public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('tag');
		$this->setAction('/tag/add-tag');
		$this->setMethod('post');
		$email = new Zend_Form_Element_Text('tag_input');
		$email->setRequired(true)
			  ->removeDecorator('label')
			  ->removeDecorator('htmlTag');
		$submit_tag = new Zend_Form_Element_Submit('submit_tag');
		$submit_tag->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper')
                                ->setLabel('Add Tags');
		$this->addElements(array($submit_tag,$email));
		$this->setElementDecorators(array('ViewHelper'),null,false);
    	/* Form Elements & Other Definitions Here ... */
    }


}

