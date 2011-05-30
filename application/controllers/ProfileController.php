<?php

class ProfileController extends Hermes_Controller_SessionController
{
	
    public function init()
    {
        parent::init();
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		
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

