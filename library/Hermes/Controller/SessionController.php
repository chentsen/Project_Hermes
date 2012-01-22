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
	    //check if i'm logged in via FB
	    $user_data = Application_Model_UserSettings::getFBData();
	    if($user_data['user'] && $user_data['user_profile']){
		$user_profile = $user_data['user_profile'];
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$pt_user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$user_profile['email']));
		if($pt_user->getIsFBAccount()){
		    $this->identity = $pt_user->getEmail();
		    $this->curUser = $pt_user;
		    return true;
		}
	    }
	    $this->_helper->redirector('index','index');
	           
        }
		//echo $this->identity;
    	/* Initialize action controller here */
    }
	public function indexAction(){
		
	}

}

