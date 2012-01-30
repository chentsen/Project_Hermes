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
		$eid = $this->_request->getParam("eid");

		//no render for now. Later on success redirect to success page, on failure, take them back to index
		$this->_helper->ViewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		if($this->getRequest()->isPost() && $this->form->isValid($this->_request->getPost())){
	    		
	    		$this->eventModel = new Application_Model_EventModel();
	    		$this->eventEmail = new Application_Model_EmailModel($eid, $this->curUser);
				$raw = $this->_request->getPost();
	    		$raw['credential'] =  $this->identity;
	    		//echo $this->identity;
				

	    		if($this->eventModel->createEvent($raw)){
					/*** send out event email ****/
					$emails = $this->eventEmail->genFriendEmails();
					
					//should just do return
				
					$subject= "Your friend has created an event";
					/*$htmlBody = $this->_helper->GenerateEmail->GenerateEmail('_email_send_notifications.phtml',

																	  array('yourName'=>$this->curUser->getFirstName(),
																			'name'=>$fullName,
																			'location'=>$raw['createEvent_location'],
																			'date'=>$dateArray,
																			'private'=>$private
																			));*/
					$this->eventEmail->sendEmailNotification($raw, $this->curUser, $this->_helper->GenerateEmail, $this->identity, $subject, $emails);
					
                    //$fullName = $this->curUser->getFirstName() . " " . $this->curUser->getLastName();
					//html body member of the
					//zend pass in helper -->  
				    /*$htmlBody = $this->_helper->GenerateEmail->GenerateEmail('_email_send_notifications.phtml',
																	  array('yourName'=>$this->curUser->getFirstName(),
																			'name'=>$fullName,
																			'location'=>$raw['createEvent_location'],
																			'date'=>$dateArray,
																			'private'=>$private
																			));*/
					
					//$this->eventEmail->sendEmail($subject, $emails, $htmlBody, $this->identity);
					
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

