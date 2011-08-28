<?php
namespace Documents;
/** @Document(collection = "wallPost", repositoryClass = "Repositories\WallPost") */
class WallPost{
	/** @Id*/
	private $postID;
	
	/** @ReferenceOne(targetDocument="Wall")*/
	private $wall;
	
	/** @Field(type="string")*/
	private $message;
	
	/** @Date*/
	private $timestamp;
	
	/** @ReferenceOne(targetDocument="User")*/
	private $user;
	
	public function __construct(User $user, Wall $wall, $message){
		$this->timestamp = new \DateTime("now");
		$this->user = $user;
		$this->wall = $wall;
		$this->message = $message;
	}
	public function getMessage(){
		return $this->message;
	}
	public function getUser(){
		return $this->user;
	}
	public function getTimestamp(){
		return $this->timestamp;
	}
	public function getPostId(){
		return $this->postId;
	}
}