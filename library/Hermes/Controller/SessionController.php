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
	$bootstrap = $this->getInvokeArg('bootstrap');	
        $this->identity = $this->_helper->GetIdentity->GetIdentity();
                $mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
                $dm = $mongoContainer->getDocumentManager('default');
                $this->curUser = $dm->getRepository('Documents\User')->findOneBy(array('email'=>$this->identity));
                //echo $this->identity;
                
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

