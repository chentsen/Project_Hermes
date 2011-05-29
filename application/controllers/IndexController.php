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
		$this->view->form = new Application_Form_Login();
		
    	// action body
    }
   
  
    	
   


}

