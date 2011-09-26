<?php
use Documents\Userflow;
class Application_Model_UserflowModel extends Application_Model_BaseModel{
	public $userflow;
	public function __construct($user = null){
		parent::__construct();
		if($user){
			$this->user = $user;
			$this->userflow = $this->user->getUserflow();
		}	
	}
	public function getNewUserflowStatus(){
		return $this->userflow->getNewFlowStatus();
	}
	public function setNewUserFlowStatus($int){
		
		//$this->userflow->setNewFlowStatus($int);
		$flow = $this->user->userflow;
		
		$flow->setNewFlowStatus($int);
		
		$this->user->setUserflow($flow);
		//echo $this->dm->persist($this->user->userflow);
		$this->dm->persist($flow);
		$this->dm->persist($this->user);
		
		
		$this->dm->flush();

	}
	
}