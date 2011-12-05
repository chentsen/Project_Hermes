<?php
namespace Documents;
/** @Document(collection="userflow", repositoryClass="Repositories\Userflow") */
class Userflow{
	/**
	 * @Id
	 */
	private $id;
	
	/**
	 * @Field(type="int")
	 */
	public $newFlowStatus;
	public function __construct($userflow = 0){
		$this->newFlowStatus = $userflow;
	}
	public function getNewFlowStatus(){
		return $this->newFlowStatus;
		
	}
	public function setNewFlowStatus($int){
		$this->newFlowStatus = $int;
	}
} 