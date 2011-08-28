<?php
namespace Documents;
/** @Document(collection="wall", repositoryClass="Repositories\Wall")*/
class Wall{
	/** @Id*/
	private $wid;
	/** @Date */
	private $timestamp;
	/** @ReferenceMany(targetDocument="WallPost")*/
	private $wallPosts;
	/** @ReferenceOne(targetDocument="Event")*/
	private $event;
	
	public function __construct(Event $event = null){
		$this->event = $event;
		$this->timestamp = new \DateTime("now");
	}
	public function addWallPost(WallPost $wallPost){
		$this->wallPosts[] = $wallPost;
	}
	public function getWallPosts(){
		return $this->wallPosts;	
	}
	public function getWid(){
		return $this->wid;
	}
	public function setWallPosts($wallPosts = null){
		$this->wallPosts = $wallPosts;
	}
	
	
}