<?php
/**
 * function retrieves identity of user if it exists, if not, returns false
 */
class Zend_Controller_Action_Helper_GetIdentity extends Zend_Controller_Action_Helper_Abstract{
	public function GetIdentity(){
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			
			$identity = $auth->getIdentity();
			//echo $identity;
			return $identity;
		}
		else{
	
			return null;
		}
	}
}