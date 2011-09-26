<?php

class ProfileController extends Hermes_Controller_SessionController
{
	
    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
                $this->firstname = $this->curUser->getFirstName();
                $this->lastname = $this->curUser->getLastName();
               
                /* Initialize action controller here */
        $bootstrap = $this->getInvokeArg('bootstrap');
		$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    }

    public function indexAction()
    {
		
    	$this->view->firstname = $this->firstname;
        $this->view->lastname = $this->lastname;
        $this->view->user = $this->curUser;
        $userflowModel = new Application_Model_UserflowModel($this->curUser);
        $options = array('formName'=>'profileSearch','fieldName' => 'profileSearch_field','viewScriptName'=>'_form_profileSearch.phtml','formAction'=>'/Search/index');
        $form = new Application_Form_Search($options);
        $this->view->form = $form;
    	$userSettings = new Application_Model_UserSettings($this->mongoContainer,$this->curUser);
    	if(!$userSettings->hasDescription($this->curUser)){
    		$userDescription = new Application_Form_PersonalDescription();
    		$this->view->userDescription = $userDescription;
    	}
    	
    	
    	$this->view->flowStatus =$userflowModel->getNewUserflowStatus(); 
  		//$userflowModel->setNewUserFlowStatus(1); 

    	$tagForm = new Application_Form_CreateTag();
    	$this->view->tagForm = $tagForm;
        //if logged in
    	if($this->identity){
			$this->view->message = 'You are logged in.';
		}
		//if not logged in
		else{
			$this->view->message = 'You are not logged in.';
		}
    	// action body
    }
 
    public function updateDescriptionAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$userSettings = new Application_Model_UserSettings($this->mongoContainer,$this->curUser);
    	$description = $this->_request->getParam("personalDescription_description");
    	$userSettings->setDescription($description);
		//redirects now. In the future this should be an AJAX function -- julian
    	$this->_redirect('/profile');
    }
    public function questionsAction(){
    	$questions = new Application_Form_Questions();
        $this->view->form = $questions;     
    	$userflowModel = new Application_Model_UserflowModel($this->curUser);
    	//echo "STATUS IS".$userflowModel->getNewUserFlowStatus();
    	if($userflowModel->getNewUserFlowStatus() < 4){
    		$this->view->questionStatus = ($userflowModel->getNewUserFlowStatus()+1); //+1 gets rid of 0 offset
    	}else{
    		$this->_redirect('/profile');
    	}
    }
    public function submitQuestionsAction(){
    	 $userflowModel = new Application_Model_UserflowModel($this->curUser);
    	 $userflowModel->setNewUserFlowStatus(intval($this->_request->getParam('q_state')));
    	 //$this->view->param = 'PARAM IS'.$this->_request->getParam('q_state');
    	//$this->_helper->viewRenderer->setNoRender();
    	$rawTags = $this->_request->getParams();
    	$this->view->request = $rawTags;
    	//parse data
    	$tagModel = new Application_Model_TagModel($this->curUser);
    	$tagModel->processQuestionTags($rawTags);
    }
     /**
     * 
     * Link for public profile
     */
    public function publicAction(){
    	$email = $this->_request->getParam("email");
    	$profileModel = new Application_Model_ProfileModel($this->mongoContainer, $email);
    	$friendRelation = new Application_Model_FriendRelation($this->identity);
    	$this->view->description = $profileModel->displayDescription();
    	$this->view->firstName = $profileModel->getUser()->getFirstName();
    	$this->view->isFriend = $friendRelation->isFriend($profileModel->getUser()->getEmail());
    	
    }


}

