<?php
use Documents\User;
class Application_Model_Search_Process{
	private $dm;
	/**
	 * 
	 * returns an object corresponding to the type which was found.
	 * 
	 */
	public function __construct($dm){
		$this->dm = $dm;
	}
	public function process($document){
		if($document['users_email']!=''){
			//echo 'FOUND A USER';
			return $this->processUsers($document);
		}
	}
	
	private function processUsers($document){
		
		$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$document['users_email']));
		return $user;
	}
	private function processEvents($document){
		
	}
}