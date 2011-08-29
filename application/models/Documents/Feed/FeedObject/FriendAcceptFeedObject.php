<?php
namespace Documents\Feed\FeedObject;

/** @EmbeddedDocument */
class FriendAcceptFeedObject extends FeedObject{
	/** @String */
	private $firstName;
	
	/** @String*/
	private $lastName;
	
	/** @String */
	private $email; //for searching purposes later
	
	public function __construct($firstName,$lastName,$email,$date){
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->date = $date;
	}
	public function getFirstName(){
		return $this->firstName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function getEmail(){
		return $this->email;
	}
}