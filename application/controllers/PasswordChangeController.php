<?php

class PasswordChangeController extends Hermes_Controller_SessionController
{

    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
        $this->firstname = $this->curUser->getFirstName();
        $this->lastname = $this->curUser->getLastName();
        $bootstrap = $this->getInvokeArg('bootstrap');
		$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
        $this->view->pageTitle = "Change your password";
    }

    public function indexAction()
    {
       $form = new Application_Form_PasswordChange();
        $this->view->form = $form;
        
    }
        public function changepasswordAction() 
    {
        $this->_helper->viewRenderer->setNoRender();
    	$userSettings = new Application_Model_UserSettings($this->mongoContainer,$this->curUser);
    	if($userSettings->updatePassword($this->_request->getPost())) {
        //$this->view->successMessage = '<h1 class="regsuccess">You have successfully changed your password.</h1>';
            $this->_redirect('/profile');
            
            
        } else {}
    }


}

