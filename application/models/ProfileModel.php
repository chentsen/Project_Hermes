<?php
use Documents\User;
class Application_Model_ProfileModel{
	private $user;
	private $dm;
	public function __construct($mongoContainer,$uid){
		$this->dm = $mongoContainer->getDocumentManager('default');
		$this->user = $this->dm->getRepository('Documents\User')->findOneBy(array('uid'=>$uid));
	}
	public function getUser(){
		return $this->user;
	}
	public function displayDescription(){
		return $this->user->getDescription();
	}
	
}