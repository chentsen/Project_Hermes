<?php

class EventListController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->identity = $this->identity;
    }

    public function indexAction()
    {
        
    }


}

