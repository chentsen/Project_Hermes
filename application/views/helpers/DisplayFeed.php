<?php

use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
class Application_View_Helper_DisplayFeed extends Zend_View_Helper_Abstract{
	public function constructFeedMessage(FeedObject $feedObject){
			if($feedObject instanceof EventFeedObject){
				$this->getEventFeedMessage($feedObject);
			}
			else if($feedObject instanceof FriendAcceptFeedObject){
				$this->getFriendAcceptFeedMessage($feedObject);
			}
			else{
				echo 'Error! FeedObject is not valid!';
			}
		}
	public function getEventFeedMessage(FeedObject $feedObject){
		echo 'Your friend '.$feedObject->getCreator()->getFirstName().' '.$feedObject->getCreator()->getLastName().' wants to';
		echo '<br />'.$feedObject->getShortDescription();
		echo '<br /> at '.$feedObject->getDate()->format('Y-m-d H:i:s');;
	}
	
	public function getFriendAcceptFeedMessage(FeedObject $feedObject){
		echo 'You and '.$feedObject->getFirstName()." ".$feedObject->getLastName()." Became friends!";
		echo '<br /> at '.$feedObject->getDate()->format('Y-m-d H:i:s');
	}

}
// DisplayFeed could instead be FeedConstructor a set of algorithms abstract which are inherited by EventFeedConstructor or 
//GeneralFeedConstructor, DisplayEvent and DisplayGeneral both call different feeds based on the subclassed constructor it calls
//you could even potentially merge generalfeed and eventfeed into one construct
