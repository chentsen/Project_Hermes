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

					$this->eventEmail->sendEmailNotification($raw, $this->curUser, $this->_helper->GenerateEmail, $this->identity, $subject, $emails);
					
	    			$this->_helper->flashMessenger->addMessage("You have successfully created your event.");
	    			
	    			//echo 'Success!';
	    		}else{
	    			echo 'Failure';
	    			$this->view->errors = array("emailExists"=>array("Something went wrong!"));
	    		}
	    		$this->_helper->redirector('index','profile');
	    	}	
	}
	
    public function uploadPicAction(){
    	//ajaxify this shit in the future
    	$form = new Application_Form_EventPic();
    	 $this->_helper->viewRenderer->setNoRender();
    	//var_dump($_FILES);
    	if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
    		if($form->image->isUploaded()){
	    		$imageModel = new Application_Model_ImageModel($this->curUser);
	    		$imageModel->makeProfilePicture($_FILES['image']['tmp_name'],$_FILES['image']['type']);
	    		$this->_redirect('/account-edit');
	    		//echo 'image saved!';
    		}
    	}else{
    		$this->_redirect('account-edit');
    	}
    	
    }

}

