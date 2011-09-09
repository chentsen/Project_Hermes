<?php
class InterestModel{
	public $interest;
	public function __construct($interest){
		$this->interest = $interest;
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
	}
	public function addUserTag($tag){
		$this->interest->addUserTag($tag);
		$this->dm->persist($this->interest);
		$this->dm->flush();
	}
	public function deleteUserTag($tag){
	
	}
}