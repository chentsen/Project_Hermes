<?php
/**
 * 
 * Controller that's extended whenever we need to test for user logins
 * @author chentsen
 *
 */
abstract class Hermes_Controller_SessionController extends Zend_Controller_Action
{
	//user's email address
	protected $identity;
    public function init()
    {
		$this->identity = $this->_helper->GetIdentity->GetIdentity();
    	//if i'm not logged in then redirect to login page no matter what.
		if(!$this->identity){
    		$this->_helper->redirector('index','index');
    	}
		//echo $this->identity;
    	/* Initialize action controller here */
    }
	public function indexAction(){
		
	}

}

