<?php

class PasswordResetController extends Hermes_Controller_SessionController
{

    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
        $this->firstname = $this->curUser->getFirstName();
        $this->lastname = $this->curUser->getLastName();
        $bootstrap = $this->getInvokeArg('bootstrap');
		$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
        $this->view->pageTitle = "Change your password";
    }

    public function indexAction()
    {
        $form = new Application_Form_PasswordReset();
        $this->view->form = $form;
        
    }


}

