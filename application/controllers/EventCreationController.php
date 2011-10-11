<?php

class EventCreationController extends Hermes_Controller_SessionController{
	private $eventModel;
    public function init()
    {
    	
    	parent::init();
    	$this->form = new Application_Form_CreateEvent();
    	/* Initialize action controller here */
           }

    public function indexAction()
    {
		
		$this->view->form = $this->form;
    	
		// action body
    }
	public function createEventAction(){
		//no render for now. Later on success redirect to success page, on failure, take them back to index
		$this->_helper->ViewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		if($this->getRequest()->isPost() && $this->form->isValid($this->_request->getPost())){
	    		
	    		$this->eventModel = new Application_Model_EventModel();
	    		$raw = $this->_request->getPost();
	    		$raw['credential'] =  $this->identity;
	    		//echo $this->identity;
	    		if($this->eventModel->createEvent($raw)){
	    			$this->_helper->flashMessenger->addMessage("You have successfully created your event.");
	    			
	    			//echo 'Success!';
	    		}else{
	    			echo 'Failure';
	    			$this->view->errors = array("emailExists"=>array("Something went wrong!"));
	    		}
	    		$this->_helper->redirector('index','profile');
	    	}	
	}

}

