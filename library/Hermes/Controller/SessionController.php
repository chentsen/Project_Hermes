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
    	//echo $this->identity;
    	/* Initialize action controller here */
    }
	public function indexAction(){
		
	}

}

