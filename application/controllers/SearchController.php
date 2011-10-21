<?php

class SearchController extends Hermes_Controller_SessionController
{
	private $mongoContainer;
	private $results;
    public function init()
    {
		parent::init();
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
		$this->view->identity = $this->identity;
    	/* Initialize action controller here */
    }

    public function indexAction()
    {
		
    	$getData = $this->_request->getQuery();
    	$field=$getData['hidden_formName'];
    	
    	
    	if($getData[$field] == '' ||!$getData[$field]){	
			//nothing there, and JS has been disabled
    		$this->_redirect('/index');	
    	}else{
    		$queryString = $getData[$field];
			//echo 'Query string is: '. $getData[$field];
	    	//echo 'didn\'t make it here';
			//returns results of search engine
			$this->results = $this->_helper->SearchIndex->search($queryString,$this->mongoContainer,$this->curUser);
	    	if($this->results){
	    		//echo 'COUNT = '. count($this->results);
	    		$this->view->results = $this->results;
	    	}
	    	else
	    		echo 'Couldn\'t find anything.';
    	}
    	
    	
    	//$this->view->results = $results;
    	// process and render that shit here
    }
  


}

