<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->pageTitle = 'Register';
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    	
		$this->userSettings = new Application_Model_UserSettings($this->mongoContainer);
    }

    public function indexAction()
    {
        // action body
    }
	public function confirmAction(){
		$this->_helper->viewRenderer->setNoRender();
		$key = $this->_request->getParam('key');
		if($key != ""){
			$result = $this->userSettings->confirmAccount($key);
			if($result){
				$this->_helper->flashMessenger->addMessage("Registration's complete! Login using your name and password");
			}else{
				$this->_helper->flashMessenger->addMessage("Sorry, we couldn't verify your registration.");
			}
			$this->_helper->redirector('Index','index');
		}
	}

}

