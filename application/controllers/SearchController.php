<?php

class SearchController extends Hermes_Controller_SessionController
{
	private $mongoContainer;
    public function init()
    {
		
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
		
    	/* Initialize action controller here */
    }

    public function indexAction()
    {
		//echo 'made it here';
    	$getData = $this->_request->getQuery();
    	$field=$getData['hidden_formName'];
    	
    	
    	//right now, anything that is passed into search box must come from "generalSearch_field"
    	//in the future a parameter can be passed in which equals the search form so that there can be specialization in search forms
		$queryString = $getData[$field];
		
    	//echo 'didn\'t make it here';
		//returns results of search engine
    	$results = $this->_helper->SearchIndex->search($queryString,$this->mongoContainer);
    	if($results)
    		echo 'RESULTS ARE'.$results[0]->getEmail();
    	else
    		echo 'FAIL';
    	
    	//$this->view->results = $results;
    	// process and render that shit here
    }	


}

