<?php
/**
 * 
 * Generic searchbox element, takes as input the form name, form action, field name, and 
 * the name of the viewscript to render it with.
 * @author chentsen
 *
 */
class Application_Form_Search extends Zend_Form{
	public function init(){
		
	}
	public function __construct($options = null){
		parent::__construct($options);
		$this->setName($options['formName']);
		$this->setAction($options['formAction']);
		$this->setMethod('get');
		$searchBox = new Zend_Form_Element_Text($options['fieldName']);
		$searchBox->setRequired(true);
		$search = new Zend_Form_Element_Submit('search');
		//use GET['hidden_formName'] is get request retrieval on the search side
		$hidden_formName = new Zend_Form_Element_Hidden('hidden_formName');
		$hidden_formName->setValue($options['fieldName']);
		$search->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper');
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>$options['viewScriptName']))));		
		$this->addElements(array($searchBox,$search,$hidden_formName));
		$this->setElementDecorators(array('ViewHelper'),null,false);
	}
}