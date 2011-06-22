<?php
use Documents\Feed\FeedObject\FeedObject;
abstract class Application_Model_Feed_FeedModel{
	protected $feed;
	protected $feedLimit = 200;
	protected $dm;
 	static function cmp($a, $b){
			 //   global $array;
			    //echo 'hi';
			    //print_r($a);
			    $value = $a->getDate()->getTimestamp();
			    $value2 = $b->getDate()->getTimestamp();
			    
			    return strcmp($value2, $value);
			}
	public function __construct($feed = null){
		$mongoContainer = Zend_Registry::get("Wildkat\DoctrineContainer");
		$this->dm = $mongoContainer->getDocumentManager('default');
		$this->feed = $feed;
	}
	
	/**
	 * takes an unordered list of objects and sorts them according to a metric
	 * Enter description here ...
	 */
	abstract protected function sort();
	/**
	 * NOTE: Later, we want to create a separate delegate function that will
	 * Adds an object to the top of the feed list
	 * @param unknown_type $feedObject
	 */
	
	public function hideObject(FeedObject $feedObject){
		$feedObject->hidden = TRUE;	
	}
	public function unhideObject(FeedObject $feedObject){
		$feedObject->hidden = FALSE;
	}
	public function push(FeedObject $feedObject){
		echo 'BEING CALLED';
		$this->feed->addFeedObject($feedObject);
		if($this->feed->countFeedObjects() > $this->feedLimit)
			$this->feed->pop();
	}
/** Shitty way of sorting by date. There has got to be a better way to do this!*/
	protected function collectionUkSort($collection){
	
		$sortedArray = array();
		foreach($collection as $object){
			$sortedArray[] = $object;
		//	echo 'running1';
		}
		
		
		//echo 'here is'. $sortedArray[0]->getDate()->getTimestamp();
		usort($sortedArray, array("Application_Model_Feed_FeedModel","cmp"));
		//echo ' COUNT IS '. count($sortedArray);
		
		
		for($i = 0; $i<count($collection);$i++){
			$collection[$i] = $sortedArray[$i];
		}
		/*
		foreach($sortedArray as $object){
			echo 'running2';
			$collection[] = $object;
		}*/
		return $collection;
	}
	public function getFeed(){
		return $this->feed;	
	}
}