<?php
namespace Documents\Feed;

/** @MappedSuperclass */
abstract class Feed{
	/** @Id*/
	protected $feed_id;
	/** @ReferenceOne(targetDocument = "Documents\User") */
	protected $user;
	
	/** @EmbedMany*/
	protected $feedObjects;
	public function __construct($user){
		$this->user = $user;
	}
	
	public function addFeedObject(FeedObject\FeedObject $feedObject){
		//$this->feedObjects[] = $feedObject;
		//echo 'COUNT VALUES :'. array_count_values($this->feedObjects);
		//echo 'being called';
		$this->feedObjects = $this->collectionUnshift($this->feedObjects,$feedObject);
		//array_unshift($this->feedObjects,$feedObject);
		
		//print_r($this->eventFeedObjects);
	}
	public function getFeedObjects(){
		return $this->feedObjects;
	}
	public function setFeedObjects($feedObjects){
		$this->feedObjects = $feedObjects;
	}
	public function countFeedObjects(){
		return count($this->feedObjects);
	}
	public function pop(){
		array_pop($this->feedObjects());
		
	}
	public function getUser(){
		return $this->user;
	}
	public function collectionUnshift($collection,$object){
		$count = count($collection);
		
		$previous = $collection[0];
		if($count > 0){
			for($i = 0; $i < $count; $i++){	
				$current = $collection[$i+1];
				$collection[$i + 1] = $previous;
				$previous = $current;
			}
			$collection[0] = $object;
			return $collection; 
		}
		else{
			$collection[] = $object;
			return $collection;
		} 
	}
	
}