<?php

class NotificationController extends Hermes_Controller_SessionController
{

    public function init()
    {
        parent::init();
		$this->view->identity = $this->identity;
    }

    public function indexAction()
    {
        
    }


}

