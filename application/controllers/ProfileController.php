<?php

class ProfileController extends Hermes_Controller_SessionController
{
	
    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
        /* Initialize action controller here */
    }

    public function indexAction()
    {
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

