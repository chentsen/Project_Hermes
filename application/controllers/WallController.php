<?php

class WallController extends Hermes_Controller_Wall_WallController
{

    private $wallModel;
	public function init()
    {
         parent::init();
		$this->view->identity = $this->identity;
        /* Initialize action controller here */
    }
	
    public function indexAction()
    {
        // action body
    }
    public function deleteAction(){
    	
    }
    public function addAction(){
    	
    }

}

