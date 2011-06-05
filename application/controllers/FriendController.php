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
    }
	public function searchAction(){

		
	}
	public function friendrequestAction(){
	    //$this->_helper->viewRenderer->setNoRender(true);
		
		$request = $this->friendRelation->createFriendRequest($_GET['friendSearch_field']);
		
		if($request){
			$this->view->requestStatus = 'Request Created!';
		}
		else{
			$this->view->requestStatus = 'Request NOT Created!';
		}
	}
	public function respondfriendrequestAction(){
		$this->_helper->ViewRenderer->setNoRender(true);
		$response = $this->_request->getParam("accept");
		$id = $this->_request->getParam("rid");
		if($response == "yes"){
			$friendRequest = $this->mongoContainer->getDocumentManager('default')->getRepository('Documents\FriendRequest')->findOneBy(array("_id"=>$id));
			if($friendRequest){
				echo 'Friend request accepted';
				$this->friendRelation->acceptFriendRequest($friendRequest);
			}
			else{
				echo 'Friend request ignored';
				$this->friendRelation->rejectFriendRequest($friendRequest);
			}
		}
		else{
			
		}
	}
	//display data.

}

