<?php

class EventController extends Hermes_Controller_Wall_WallController
{
	//private $event;
    
	public function init()
    {
        parent::init();
      
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->identity = $this->identity;
    	$eid = $this->_request->getParam("eid");
		$this->view->eid = $this->_request->getParam("eid");
        $event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$eid));
        $eventModel = new Application_Model_EventModel($event);
	
    	$this->view->event = $event;
	$this->view->curUser = $event->getCreator();
	$this->view->didRequest = $eventModel->hasRequestedMembership($this->identity);
        //1. if I am creator
		$this->view->creatorName = $event->getCreator()->getFirstName(). " " .substr($event->getCreator()->getLastName(),0,1). ".";
        if($this->identity == $event->getCreator()->getEmail()){
    		$this->_helper->ViewRenderer('index_creator');
			$this->view->pageTitle = "I want to " .
				$event->getShortDescription();
				$indexCreator = 'hello';
			$this->view->indexCreator = $indexCreator;
    	}
    	else if($eventModel->isMember($this->identity,$event->getMembers())){
    		$this->_helper->ViewRenderer('index_member');
			$this->view->pageTitle = "You want to" .
				$event->getShortDescription();
			$this->view->indexMember = true;
    	}
    	//I'm not a member, and I'm not a creator
    	else if(!$event->isPrivate()){
    		$this->_helper->ViewRenderer('index_public');

			$this->view->pageTitle = "Join " . $event->getCreator()->getFirstName() . " " .substr($event->getCreator()->getLastName(),0,1) .  ". and " .
			$this->view->indexPublic = true;
				$event->getShortDescription();
		
    	}
    	else{
    		echo 'This is a private event. Sorry!';
    	}
    	// action body
    }
	
    public function requestAction(){
    	$this->_helper->ViewRenderer->setNoRender(true);
    	$eid = $this->_request->getParam("eid");
    	$event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$eid));	
    	if($event){
    		$eventModel = new Application_Model_EventModel($event);
    		$result = $eventModel->attendRequest($this->identity);
    		if($result){
				$this->_helper->flashMessenger->addMessage("You have successfully indicated your interest in this event. Thanks!");
				$this->_redirect('/profile');
				
    		}else{
    			echo "Something went wrong.";
    		}
    	}	
    	else{
    		echo 'couldn\'t find event';
    	}
    }
    public function responseAction(){
    	$this->_helper->ViewRenderer->setNoRender(true);
    	$eid =  $this->_request->getParam("eid");
    	$email = $this->_request->getParam("uid");
    	//response y means add user, response n means deny user	
    	$response = $this->_request->getParam("response");
    	$event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$eid));
    	$user = $this->dm->getRepository('Documents\User')->find(intval($email));
    	$eventModel = new Application_Model_EventModel($event);
	$data = array();
    	if($this->identity==$event->getCreator()->getEmail() && $response == "y"){
    		$eventModel->acceptRequest($user);
		$data['success'] = true;
		$data['msg'] = 'You successfully added '.$user->getFirstName().' to the event.';
    		
    	}else if($this->identity==$event->getCreator()->getEmail() && $response == "n"){
    		$data['success'] = true;
		$data['msg'] = 'You declined '.$user->getFirstName().'\'s request.';
		$eventModel->rejectRequest($user);

    	}else{
	    
	}
	$this->_helper->json($data);
    	//is the credential = to the credential of the creator?
    	//if yes, run method with the guys email as the id and eid as the other id and generate new user and new event
    	//
    }
  //remove
   /*public function emailAction() {
		$this->_helper->ViewRenderer->setNoRender(true);
    	$eid = $this->_request->getParam("eid");
		$email = new Application_Model_EmailModel($eid, $this->curUser);
        $email->sendNotificationEmails();
	
   }*/

}

