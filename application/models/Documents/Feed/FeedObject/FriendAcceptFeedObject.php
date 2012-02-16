<?php
namespace Documents\Feed\FeedObject;

/** @EmbeddedDocument */
class FriendAcceptFeedObject extends FeedObject{
	/** @String */
	private $firstName;
	
	/** @String*/
	private $lastName;
	
	/** @String */
	private $uid; //for searching purposes later
	
	public function __construct($firstName,$lastName,$uid,$date){
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->uid = $uid;
		$this->date = $date;
	}
	public function getFirstName(){
		return $this->firstName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function getUid(){
		return $this->uid;
	}
}