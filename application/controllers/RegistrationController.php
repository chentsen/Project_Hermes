<?php

class RegistrationController extends Zend_Controller_Action
{

    public function init()
    {
		$this->view->pageTitle = 'Register';
    	/* Initialize action controllers here */
    }

    public function indexAction()
    {
		
    	$form = new Application_Form_Registration();
		$form->addIdentical($_POST['password']);
		if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
			$this->view->successMessage = "Success!";
		}
		else{
			$this->view->form = $form;
		}
    	// action body
    }

    public function registerAction()
    {
        // action body
    }


}



