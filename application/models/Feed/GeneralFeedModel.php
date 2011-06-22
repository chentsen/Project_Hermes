<?php
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
use Documents\Feed\FeedObject\FeedObject;

class Application_Model_Feed_GeneralFeedModel extends Application_Model_Feed_FeedModel{
	public function __construct($feed){
		parent::__construct($feed);
	}
	public function sort(){
		$feedObjects = $this->feed->getFeedObjects();
		//print_r( $this->feed->getFeedObjects());
		$feedObjects = $this->collectionUkSort($feedObjects);		
		$this->feed->setFeedObjects($feedObjects);
	}
	// Same as the one in EventFeedModel
	public function createEventFeedObject($inputs){
		$shortDescription = $inputs['shortDescription'];
		$eid = $inputs['eid'];
		$date = $inputs['date'];
		$creator = $inputs['creator'];
		$eventFeedObject = new Documents\Feed\FeedObject\EventFeedObject( $shortDescription, $eid, $date,$creator);
		return $eventFeedObject;
	}
	public function createFriendAcceptFeedObject($inputs){
		$firstName = $inputs['firstName'];
		$lastName = $inputs['lastName'];
		$date = $inputs['date'];
		$email = $inputs['email'];
		$friendAcceptFeedObject = new FriendAcceptFeedObject($firstName, $lastName, $email, $date);
		return $friendAcceptFeedObject;
	}
	
	
}