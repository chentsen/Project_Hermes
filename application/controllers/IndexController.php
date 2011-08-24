<?php

class IndexController extends Zend_Controller_Action
{
	
    public function init()
    {
		if($this->_helper->FlashMessenger->hasMessages()){
    		$this->view->flashMessages = $this->_helper->FlashMessenger->getMessages();
		}
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    	
		$this->userSettings = new Application_Model_UserSettings($this->mongoContainer);
    	/* Initialize action controller here */
                 
    }

    public function indexAction()
    {
       $auth = Zend_Auth::getInstance();
	if($auth->hasIdentity()){
                    $this->_redirect('/profile');
                }
		
		//$test = new Application_Model_Feed_EventFeedModel();	
		//$test->testFunction();
    	$form = new Application_Form_Login();
    	$this->view->form = $form;
    	if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
    		$authenticated = $this->userSettings->authenticateUser($_POST['email'], $_POST['password']);
    		
    		if($authenticated){
    			$this->_helper->redirector('index','profile');
    			//$this->view->message = "SUCCESS";
    			//redirect to login page
    		}
    		else{
    			$this->view->errors = array("emailExists"=>array("Your username and/or password were not recoginized. Please try again."));
    			return;
    		}
    	}
    	else{
    		//$this->view->errors = $form->getMessages();
    	}
    	$this->view->form = $form;
    	// action body
        
    }
    public function ajaxformAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
                
                //pull content json
                $form = new Application_Form_Registration();
                $form->isValid($this->_getAllParams());
		$json = $form->getMessages();
		header('Content-type: application/json');
		echo Zend_Json::encode($json);
	}
    public function logoutAction()
        {
                 $auth = Zend_Auth::getInstance();
                 $auth->clearIdentity();
                 $this->_redirect('/index');
                 
        }

}

