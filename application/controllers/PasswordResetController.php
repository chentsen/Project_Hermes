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
        $user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$_POST['email']));
        
        //move into index
        if ($this->getRequest()->isPost() && $form->isValid($this->_request->getPost()) && !$user->getIsFBAccount()) {
        
        $userSettings = new Application_Model_UserSettings($this->mongoContainer, null);
    	$newPass = $userSettings->resetPassword($_POST['email']);
        $this->eventEmail = new Application_Model_EmailModel();
        $this->eventEmail->sendPasswordReset($newPass, null, $this->_helper->GenerateEmail, $user, "Reset your Password");
        //success message not appearing    
        //$this->view->successMessage = '<h1 class="regsuccess">You have successfully changed your password.</h1>';
        $this->_helper->flashMessenger->addMessage("Please check your email to finish resetting your password.");
        } else if ($this->getRequest()->isPost() && $form->isValid($this->_request->getPost()) && $user->getIsFBAccount()) {
            $this->_helper->flashMessenger->addMessage("You cannot reset your password because it is tied to your Facebook account.");
        }
        $this->_redirect('/index');
        
    }
    
    

}

