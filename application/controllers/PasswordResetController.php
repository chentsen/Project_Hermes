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
    	
		$this->userSettings = new Application_Model_UserSettings($this->mongoContainer);
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
        $this->_helper->viewRenderer->setNoRender();
        $newPassword = $this->randString(8);
        
        $this->curUser = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$_POST['email']));
        $userSettings = new Application_Model_UserSettings($this->mongoContainer,$curUser);
    	if($userSettings->resetPassword($newPassword, $_POST['email'])) {
        //$this->view->successMessage = '<h1 class="regsuccess">You have successfully changed your password.</h1>';
            //$this->_redirect('/profile');
            echo $newPassword;
        }
    }
    function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $str = '';
        $count = strlen($charset);
        while ($length--) {
           $str .= $charset[mt_rand(0, $count-1)];
        }
    return $str;
    }

}

