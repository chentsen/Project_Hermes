<?php

class ProfileController extends Hermes_Controller_SessionController
{
	
    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
                $this->firstname = $this->curUser->getFirstName();
                $this->lastname = $this->curUser->getLastName();
                /* Initialize action controller here */
    }

    public function indexAction()
    {
	$this->view->firstname = $this->firstname;
        $this->view->lastname = $this->lastname;
        $options = array('formName'=>'profileSearch','fieldName' => 'profileSearch_field','viewScriptName'=>'_form_profileSearch.phtml','formAction'=>'/Search/index');
        $form = new Application_Form_Search($options);
        $this->view->form = $form;
    	//if logged in
    	if($this->identity){
			$this->view->message = 'You are logged in.';
		}
		//if not logged in
		else{
			$this->view->message = 'You are not logged in.';
		}
    	// action body
    }


}

