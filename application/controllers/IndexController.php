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
        $this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
    	$this->url = Zend_Registry::get('config')->siteInformation->url;
                 
    }

    public function indexAction()
    {	
        
        $this->_helper->layout->setLayout('layout_outside');                
       $auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
                    $this->_redirect('/profile');
                }
		
                
    	$document = new SolrInputDocument();
    	$reg = new Application_Form_Registration();
		$reg->addIdentical($_POST['password']);
		//Betakey Validation -- remove when full release
		$keyValid = $this->dm->getRepository('Documents\Betakey')->findOneBy(array('key'=>$_POST['betakey']));
		if($this->getRequest()->isPost() && $reg->isValid($this->_request->getPost())){
			if(!$keyValid){
				$this->view->errors = array("betaExists"=>array("Invalid betakey, please enter the key you received in your invite to try out Plumetype."));
				//remove the Betakey
				
				//end Betakey stuff
				return;
			}else{
				$this->dm->remove($keyValid);
			}	
			
			$activationCode = $this->userSettings->register($this->_request->getPost());
			//returns either false for unsuccessful serialization, or the activationCode
			
			if($activationCode){

				
				$this->view->successMessage = '<h1 class="regsuccess">Registration Successful! Please complete registration by clicking on the link sent to your email.</h1>';
				$mail = new Zend_Mail();

				$htmlBody = $this->_helper->GenerateEmail->GenerateEmail('_email_confirm_registration.phtml',
																	  array('name'=>$_POST['firstName'],
																	 'activationUrl'=>$this->url,
																	 'activationCode'=>$activationCode));
				//$this->view->htmlBody = $htmlBody;
				$mail->setBodyHtml($htmlBody);
				$mail->setFrom('activation@plumetype.com', 'Plumetype Activation');
				$mail->addTo($_POST['email']);
				$mail->setSubject('Activate Your Plumetype Account');
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
		
			
			//$this->view->errors = $form->getMessages();
			
		}
			$this->view->reg = $reg;
                        
                        
                        
       
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
                 Zend_Session::forgetMe();
                 $this->_redirect('/index');
                 
        }

}

