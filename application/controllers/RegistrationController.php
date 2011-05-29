<?php

class RegistrationController extends Zend_Controller_Action
{

    public function init()
    {
		$this->view->pageTitle = 'Register';
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    	
		$this->userSettings = new Application_Model_UserSettings($this->mongoContainer);
    	$this->url = Zend_Registry::get('config')->siteInformation->url;
    	
    	/* Initialize action controllers here */
    }

    public function indexAction()
    {
		
    	$form = new Application_Form_Registration();
		$form->addIdentical($_POST['password']);
		if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
			$activationCode = $this->userSettings->register($this->_request->getPost());
			//returns either false for unsuccessful serialization, or the activationCode
			if($activationCode){
				$this->view->successMessage ='SUCCESS';
				$mail = new Zend_Mail();
				$htmlBody = $this->_helper->GenerateEmail->GenerateEmail('_email_confirm_registration.phtml',
																	  array('name'=>$_POST['firstName'],
																	 'activationUrl'=>$this->url,
																	 'activationCode'=>$activationCode));
				//$this->view->htmlBody = $htmlBody;
				$mail->setBodyHtml($htmlBody);
				$mail->setFrom('admin@plumetype.com', 'Andy');
				$mail->addTo($_POST['email']);
				$mail->setSubject('Confirm your registration with plumetype');
				$mail->send();
				// redirect to some page and fire off email and return
				return;			
			}
			else{
				$this->view->errors = array("emailExists"=>array("This email is already registered with a user account. Forgot your password? No worries, click here"));
				//retrieve error message from application.ini here and add it to the view
			}
		}
		else{
			$this->view->errors = $form->getMessages();
			
		}
			$this->view->form = $form;
    	// action body
    }

    public function registerAction()
    {
        // action body
    }


}



