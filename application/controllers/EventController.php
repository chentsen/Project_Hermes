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
    	//page that is shown depends on the user's status for now, use if statement to determine
        //potential pages 1.Member 2.Creator 3.Public we might want to push display logic further down, at the view
        //helper level (consult with Julian)
        $event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$eid));
        $eventModel = new Application_Model_EventModel($event);
       
    	$this->view->event = $event;
        //1. if I am creator
        if($this->identity == $event->getCreator()->getEmail()){
    		$this->_helper->ViewRenderer('index_creator');
    	}
    	else if($eventModel->isMember($this->identity,$event->getMembers())){
    		$this->_helper->ViewRenderer('index_member');
    	}
    	//I'm not a member, and I'm not a creator
    	else if(!$event->isPrivate()){
    		$this->_helper->ViewRenderer('index_public');
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
    			echo "You have successfully indicated your interest in this event. Thanks!";
    		}else{
    			echo "Something went wrong";
    		}
    	}	
    	else{
    		echo 'couldn\'t find event';
    	}
    }
    public function responseAction(){
    	$this->_helper->ViewRenderer->setNoRender(true);
    	$eid =  $this->_request->getParam("eid");
    	$email = $this->_request->getParam("email");
    	//response y means add user, response n means deny user
    	$response = $this->_request->getParam("response");
    	$event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$eid));
    	$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$email));
    	$eventModel = new Application_Model_EventModel($event);
    	if($this->identity==$event->getCreator()->getEmail() && $response == "y"){
    		$eventModel->acceptRequest($user);
    		echo 'User has been accepted';
    	}else if($this->identity==$event->getCreator()->getEmail() && $response == "n"){
    		$eventModel->rejectRequest($user);
    		echo 'User has been rejected';
    	}
    	//is the credential = to the credential of the creator?
    	//if yes, run method with the guys email as the id and eid as the other id and generate new user and new event
    	//
    }
   

}

