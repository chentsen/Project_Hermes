<?php
class Application_Form_CreateEvent extends Zend_Form{
	public function init(){
		
	}
	public function __construct($options = null){
		parent::__construct($options);
		$this->setName('createEvent');
		$this->setAction('eventCreation/create-event');
		$this->setMethod('POST');
		
		$shortDescription = new Zend_Form_Element_Text('createEvent_shortDescription');
		$shortDescription->setRequired(true)
						 ->addValidator('StringLength',array('max'=>40,'allowWhiteSpace'=>true));
                                                 
		//month stuff
		/*$months = array('1'=>"Janurary",'Februrary'=>2,'March'=>3,'April'=>4,'May'=>5,'June'=>6,
						'July'=>7,'August'=>8,'September'=>9,'October'=>10,'November'=>11,'December'=>12);
		$month = new Zend_Form_Element_Select('createEvent_month');
		$month->addMultiOptions($months);*/

		$shortDescription = new Zend_Form_Element_Text('createEvent_shortDescription');
		$shortDescription->setRequired(true)
						 ->addValidator('StringLength',array('max'=>40,'allowWhiteSpace'=>true));
						 
		$location = new Zend_Form_Element_Text('createEvent_location');
		$location->addValidator("StringLength", array('max'=>60,'allowWhiteSpace'=>true));
		
                
                $date = new Zend_Form_Element_Text('createEvent_date');
                
		/*$days = $this->generateDays();
		$day = new Zend_Form_Element_Select('createEvent_day');
		$day->addMultiOptions($days);
		
		$year = new Zend_Form_Element_Select('createEvent_year');
		$year->addMultiOption(2011,'2011');*/
		
		$private = new Zend_Form_Element_Select('createEvent_private');
		$private->setMultiOptions(array("y"=>"yes","n"=>"no"));		
		
		$private = new Zend_Form_Element_Select('createEvent_private');
		$private->setMultiOptions(array("n"=>"shouldn't","y"=>"should"));	
		
		$longDescription = new Zend_Form_Element_Textarea('createEvent_longDescription',array("rows"=>3,'cols'=>50));
		$longDescription->addValidator('StringLength',array('max'=>140,'allowWhiteSpace'=>true));
		
		$submit = new Zend_Form_Element_Submit('createEvent_submit',array('label' => 'Create Event!'));
		
		
		$moreOptions = new Zend_Form_Element_Button('createEvent_moreOptions');
		
		$this->addElements(array($date,$private,$location,$longDescription,$shortDescription,$submit,$moreOptions));
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_createEvent.phtml'))));
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
	}
	//wrong date. Javascript needs to be fixed on julian side to dynamically update with correct dates for placeholder purposes only
	
	/*private function generateDays(){
		$datesArray = array();
		for($i = 1; $i<=30;$i++){
			$datesArray["{$i}"]=$i;
		}
		return $datesArray;
	}*/
	
}