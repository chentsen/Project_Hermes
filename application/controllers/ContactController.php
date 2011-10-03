<?php

class ContactController extends Hermes_Controller_SessionController
{

    public function init()
    {
        $this->view->pageTitle = 'Contact Us';
        
    	$bootstrap = $this->getInvokeArg('bootstrap');
        /* Initialize action controller here */
        $this->url = Zend_Registry::get('config')->siteInformation->url;
    }

    public function indexAction()
    {
        // action body
        $form = new Application_Form_Contact();
        $this->view->form = $form;
        
        if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
			//$activationCode = $this->userSettings->register($this->_request->getPost());
			//returns either false for unsuccessful serialization, or the activationCode
			
				
				$mail = new Zend_Mail();
				//$this->view->htmlBody = $htmlBody;
				$mail->setBodyHtml($_POST['text']);
				$mail->setFrom($_POST['email'], $_POST['name']);
				$mail->addTo('999@dispostable.com');
				$mail->setSubject($_POST['subject']);
				$mail->send();
				$form->reset();
                                // redirect to some page and fire off email and return
				return;	
                                 
                             
			}
			
		
		else{
			//$this->view->errors = $form->getMessages();
		
		}
                        
			$this->view->form = $form;
                       
    }

}

