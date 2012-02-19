<?php
//Friends page with list of friends, add friends, accept, reject. All of this will be displayed with view helpers
//Logic changes will be called from controllers.
use Symfony\Component\Console\Application;
class FriendController extends Hermes_Controller_SessionController
{
	private $friendRelation;
    public function init()
    {
    
    	parent::init();  	
    	
		$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    	$this->friendRelation = new Application_Model_FriendRelation($this->identity,$this->mongoContainer);
    	$this->view->identity = $this->identity;
    	/* Initialize action controller here */
    }

    public function indexAction()
    {
        	//action to be changed to search later
    		$options = array('formName'=>'friendSearch','fieldName' => 'friendSearch_field','viewScriptName'=>'_form_friendSearch.phtml','formAction'=>'/friend/friendRequest');
        	$form = new Application_Form_Search($options);
        	$this->view->form = $form;
			$friendRequest = $this->mongoContainer->getDocumentManager('default')->getRepository('Documents\FriendRequest')->findOneBy(array("_id"=>3));
			
			
    }
	public function searchAction(){
		
		
	}
	public function friendrequestAction(){
	    //$this->_helper->viewRenderer->setNoRender(true);
		$param = $this->_request->getParam('requestee');
		$request = $this->friendRelation->createFriendRequest($param);
		
		if($request){
			$this->_helper->flashMessenger->addMessage("Friend request sent!");
				$this->_redirect('/profile');
		}
		else{
			$this->_helper->flashMessenger->addMessage("Sorry, an error occurred with this request. Please try again later.");
				$this->_redirect('/profile');
		}
	}
	public function respondfriendrequestAction(){
		$this->_helper->ViewRenderer->setNoRender(true);
		$response = $this->_request->getParam("accept");
		$id = $this->_request->getParam("rid");
		if($response == "yes"){
			$friendRequest = $this->mongoContainer->getDocumentManager('default')->getRepository('Documents\FriendRequest')->findOneBy(array("_id"=>$id));
			if($friendRequest){
				$this->_helper->flashMessenger->addMessage("Friend request accepted!");
				$this->friendRelation->acceptFriendRequest($friendRequest);
				//insert email stuff here
				$this->eventEmail = new Application_Model_EmailModel($eid, $this->curUser);
				
				if($this->friendRelation->isFriend($friendRequest)) {
						$subject= "Your friend ". $this->curUser->getEmail() ." has accepted your friend request";
						$this->eventEmail->sendFriendedEmail($subject, $this->_helper->GenerateEmail, $friendRequest->getRequester(), $this->curUser);
						
	    		
				}
				$this->_redirect('/profile');
			}
			
		}
		else if ($response == "no") {
			$friendRequest = $this->mongoContainer->getDocumentManager('default')->getRepository('Documents\FriendRequest')->findOneBy(array("_id"=>$id));
			if($friendRequest){
				$this->_helper->flashMessenger->addMessage("Friend request ignored");
				$this->friendRelation->rejectFriendRequest($friendRequest);
				$this->_redirect('/profile');
			}
		}
	}
	//display data.

}

