<?php
use Documents\Feed\EventFeed;
use Documents\Feed\FeedObject\FeedObject;
class Application_Model_Feed_EventFeedModel extends Application_Model_Feed_FeedModel{
	public function __construct($feed){
		parent::__construct($feed);
	}
	//sort by date
	public function sort(){
		$feedObjects = $this->feed->getFeedObjects();
		//print_r( $this->feed->getFeedObjects());
		$feedObjects = $this->collectionUkSort($feedObjects);		
		$this->feed->setFeedObjects($feedObjects);
	}
	
	public function createEventFeedObject($inputs){
		$shortDescription = $inputs['shortDescription'];
		$eid = $inputs['eid'];
		$date = $inputs['date'];
		$creator = $inputs['creator'];
		$event = $inputs['event'];
                $eventFeedObject = new Documents\Feed\FeedObject\EventFeedObject( $shortDescription, $eid, $date,$creator,$event);
		return $eventFeedObject;
	}
	
	
			
}