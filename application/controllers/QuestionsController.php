<?php

class QuestionsController extends Hermes_Controller_SessionController
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->pageTitle = "Questions to Get Started";
    	$bootstrap = $this->getInvokeArg('bootstrap');
         
    	
    }

    public function indexAction()
    {
       
    	$form = new Application_Form_Questions();
        $this->view->form = $form;
        
        // action body
    }

}
