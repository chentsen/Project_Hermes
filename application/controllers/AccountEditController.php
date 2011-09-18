<?php

class AccountEditController extends Hermes_Controller_SessionController
{

    public function init()
    {
        
        parent::init();
     

		$this->view->identity = $this->identity;
                $this->firstname = $this->curUser->getFirstName();
                $this->lastname = $this->curUser->getLastName(); 
                $this->city = $this->curUser->getCity();
                
                /* Initialize action controller here */
                $bootstrap = $this->getInvokeArg('bootstrap');
		$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
        /* Initialize action controller here */
        $this->view->pageTitle = "Edit Your Account";
        

    }

    public function indexAction()
    {
        // action body
        $this->view->firstname = $this->firstname;
        $this->view->lastname = $this->lastname;
        $this->view->city = $this->city;
        
        
        $options = array('firstName'=>$this->firstname,'lastName'=>$this->lastname, 'city'=>$this->city);
        $form = new Application_Form_EditAccount($options);
        $this->view->form = $form;
        
      
        
    }
    public function updateaccountAction() 
    {
        $this->_helper->viewRenderer->setNoRender();
    	$userSettings = new Application_Model_UserSettings($this->mongoContainer,$this->curUser);
    	$userInfo = $userSettings->updateinfo($this->_request->getPost());
        
    	$this->_redirect('/accountEdit');
    }

}
