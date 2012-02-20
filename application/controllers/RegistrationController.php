<?php
use Facebook\Facebook;
class RegistrationController extends Zend_Controller_Action
{

    public function init()
    {
		$this->view->pageTitle = 'Register';
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
        $this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$this->userSettings = new Application_Model_UserSettings($this->mongoContainer);
    	$this->url = Zend_Registry::get('config')->siteInformation->url;
    	
    	/* Initialize action controllers here */
    }

    public function indexAction()
    {
	$this->_helper->layout()->disableLayout();
	$this->_helper->viewRenderer->setNoRender();
	$auth = Zend_Auth::getInstance();
	if($auth->hasIdentity()){
                    $this->_redirect('/profile');
                }	
		$document = new SolrInputDocument();
		$form = new Application_Form_Registration();
		$form->addIdentical($_POST['password']);
		//Betakey Validation -- remove when full release
		$keyValid = $this->dm->getRepository('Documents\Betakey')->findOneBy(array('key'=>$_POST['betakey']));
		if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
			if(!$keyValid){
				$this->_helper->flashMessenger->addMessage("Invalid betakey, please enter the key you received in your invite to try out PlumeType.");
				//remove the Betakey
				$this->_redirect('/index');
				//end Betakey stuff
				
			}else{
				 
				$this->dm->remove($keyValid);
				$this->dm->flush();
				
			}	
			
			$activationCode = $this->userSettings->register($this->_request->getPost());
			//returns either false for unsuccessful serialization, or the activationCode
			
			if($activationCode){

				
				$this->view->successMessage = '<h1 class="regsuccess">Registration Successful! Please complete registration by clicking on the link sent to your email.</h1>';
				$mail = new Zend_Mail();
				//$transport = Zend_Registry::get('SmtpTransport');
				$htmlBody = $this->_helper->GenerateEmail->GenerateEmail('_email_confirm_registration.phtml',
																	  array('name'=>$_POST['firstName'],
																	 'activationUrl'=>$this->url,
    																	 'activationCode'=>$activationCode));
				//$this->view->htmlBody = $htmlBody;
				$mail->setReplyTo('activation@plumetype.com', 'Plumetype');
				$mail->addHeader('MIME-Version', '1.0');
				$mail->addHeader('Content-Transfer-Encoding', '8bit');
				$mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
				$mail->setBodyHtml($htmlBody);
				$mail->setFrom('activation@plumetype.com', 'Plumetype Activation');
				$mail->addTo($_POST['email']);
				$mail->setSubject('Activate Your Plumetype Account');
				$mail->send();
				$this->_helper->flashMessenger->addMessage("You're almost done! Check your email to confirm your account and start meeting people instantly.");
				$this->_redirect('/index');
				// redirect to some page and fire off email and return
				return;	
                                
			}
			else{
				$this->_helper->flashMessenger->addMessage("This email is already registered with a user account. Forgot your password? No worries, click here");
				$this->_redirect('/index');
				//retrieve error message from application.ini here and add it to the view
			}
		}
		else if($this->getRequest()->isPost() && !$form->isValid($this->_request->getPost()))
		{
			
			$messages = $form->getMessages();
			foreach($messages as $message){
			    $this->_helper->flashMessenger->addMessage($message);
			}
			
		}else{
		    $reg = new Application_Form_Registration();
		    $json['form'] =  $reg->render();
		    $this->_helper->json($json);
		    $this->_redirect('/index');
		}
			//$this->view->form = $form;
			
    	// action body
    }

    public function registerAction()
    {
        // action body
    }
    public function fbLoginAction(){
	$this->_helper->layout()->disableLayout();
	$this->_helper->viewRenderer->setNoRender();
	$data_obj = Application_Model_UserSettings::getFBData();
	$user = $data_obj['user'];
	$user_profile = $data_obj['user_profile'];
	// Login or logout url will be needed depending on current user state.
	if ($user) {
	   $pt_user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$user_profile['email']));
	    if(!$pt_user){
		$result = $this->userSettings->fbRegister($user_profile);
		if($result === true){
		    $json['success'] = true;
		    //registration was a success, send the user to profile page
		    $this->_helper->json($json);
		}else if($result === false){
		    $json['form'] = 'An account associated with this Facebook account email already exists';
		     $this->_helper->json($json);
		}else{
		    //render the form view and echo it.
		    $fbRegistration = new Application_Form_FbRegistration($result);
		    
		    $json['form'] =  $fbRegistration->render();
		    
		    $this->_helper->json($json);
		    
		    //do something to tell about failed registration
		}
	    }
	    //we should log the user into their FB linked account!
	    else if($pt_user && $pt_user->getIsFBAccount()){
		  $json['fb_account_exists'] = true;
		    //registration was a success, send the user to profile page
		    $this->_helper->json($json);
	    }
	    else if($pt_user && !$pt_user->getIsFBAccount()){
		 $json['fb_account_exists'] = false;
		    //registration was a success, send the user to profile page
		    $this->_helper->json($json);
	    }
	    //user is logged in so we can register
	} 
    }
    public function fbRetryAction(){
	$form = new Application_Form_FbRegistration();
	$this->_helper->viewRenderer->setNoRender();
	if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
	    $keyValid = $this->dm->getRepository('Documents\Betakey')->findOneBy(array('key'=>$_POST['betakey']));
	    if(!$keyValid){
		    $this->view->errors = array("betaExists"=>array("Invalid betakey, please enter the key you received in your invite to try out Plumetype."));
		    //remove the Betakey
		    echo ' KEY IS INVALID ';
		    echo $_POST['betakey'];
		    return;
	    }else{
		    $success = $this->userSettings->fbRegister($this->_request->getPost(),true);
		    $this->dm->remove($keyValid);
		    $this->dm->flush();
		    if($success === true){
			$this->_redirect('/profile/');
			exit();	
		    }else{
			var_dump($success);
			echo 'FAIL! EMAIL EXISTS';
		    }
	    }
	}
    }
    


}



