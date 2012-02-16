<?php

class PasswordResetController extends Zend_Controller_Action
{

    public function init()
    {
        if($this->_helper->FlashMessenger->hasMessages()){
			$this->view->flashMessages = $this->_helper->FlashMessenger->getMessages();
		}
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    	
		//$this->userSettings = new Application_Model_UserSettings($this->mongoContainer);
    	/* Initialize action controller here */
        $this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
    	$this->url = Zend_Registry::get('config')->siteInformation->url;
        
        
    }

    public function indexAction()
    {
        $form = new Application_Form_PasswordReset();
        $this->view->form = $form;
    }
    public function resetpasswordAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $form = new Application_Form_PasswordReset();
        //move into index
        if ($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())) {
        $userSettings = new Application_Model_UserSettings($this->mongoContainer,$curUser);
    	$newPass = $userSettings->resetPassword($_POST['email']);
        $this->eventEmail = new Application_Model_EmailModel(null, $this->curUser);
        $this->eventEmail->sendPasswordReset($newPass, null, $this->_helper->GenerateEmail, $_POST['email'], "Reset your Password");
        //success message not appearing    
        $this->view->successMessage = '<h1 class="regsuccess">You have successfully changed your password.</h1>';
        }
        $this->_redirect('/index');
        
    }
    
    

}

