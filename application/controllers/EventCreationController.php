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
					$this->eventEmail->genFriendEmails();
					$emails = $this->eventEmail->emails;
					foreach ($emails as $email)
						{
							$email .= ",";	
						}
					$dateArray = explode('/',$raw['createEvent_date']);
					$dateArray = $dateArray[1] . "/" . $dateArray[0] . "/" . $dateArray[2];
					$private = (($raw['createEvent_private'] == 'y') ? "Yes" : "No");
                    $fullName = $this->curUser->getFirstName() . " " . $this->curUser->getLastName();
				    $htmlBody = $this->_helper->GenerateEmail->GenerateEmail('_email_send_notifications.phtml',
																	  array('yourName'=>$this->curUser->getFirstName(),
																			'name'=>$fullName,
																			'location'=>$raw['createEvent_location'],
																			'date'=>$dateArray,
																			'private'=>$private
																			));
					$subject= "Your friend has created an event";
					$this->eventEmail->sendEmail($subject, $email, $htmlBody, $this->identity);
					
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

