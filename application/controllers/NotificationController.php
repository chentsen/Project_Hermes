<?php

class NotificationController extends Hermes_Controller_SessionController
{

    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
                $this->firstname = $this->curUser->getFirstName();
                $this->lastname = $this->curUser->getLastName();
    }

    public function indexAction()
    {
        // action body
    }


}

