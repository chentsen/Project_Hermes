<?php

class AccountEditController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->pageTitle = "Edit Your Account";
        $bootstrap = $this->getInvokeArg('bootstrap');
    }

    public function indexAction()
    {
        // action body
        $form = new Application_Form_EditAccount();
        $this->view->form = $form;
        
    }


}

