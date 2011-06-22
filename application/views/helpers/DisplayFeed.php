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
		echo 'You have joined '.$feedObject->getCreator()->getFirstName().' '.$feedObject->getCreator()->getLastName().'\'s event';
		echo '<br />'.$feedObject->getShortDescription();
		echo '<br /> at '.$feedObject->getDate()->format('Y-m-d H:i:s');;
	}
	
	public function getFriendAcceptFeedMessage(FeedObject $feedObject){
		echo 'You and '.$feedObject->getFirstName()." ".$feedObject->getLastName()." Became friends!";
		echo '<br /> at '.$feedObject->getDate()->format('Y-m-d H:i:s');
	}

}