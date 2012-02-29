<?php

use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
class Application_View_Helper_DisplayFeed extends Zend_View_Helper_Abstract{
	
	public function constructFeedMessage(FeedObject $feedObject, $identity){
			if($feedObject instanceof EventFeedObject){
				$this->getEventFeedMessage($feedObject, $identity);
			}
			else if($feedObject instanceof FriendAcceptFeedObject){
				$this->getFriendAcceptFeedMessage($feedObject);
			}
			else{
				echo 'Error! FeedObject is not valid!';
			}
		}
	public function getEventFeedMessage(FeedObject $feedObject, $identity = null){
		$uid = $feedObject->getCreator()->getUid();
		echo "<img style='float: left; margin-right: 8px; margin-top: 1px;' src='/img/profile-pic/uid/{$uid}' width='30' height='30'/>";
		echo "<div class='individual-object'>Your friend <a href='/profile/public/uid/{$uid}'> ".addslashes($feedObject->getCreator()->getFirstName())." ".addslashes($feedObject->getCreator()->getLastName())."</a> wants to";
		echo " <a href = '/event/index/eid/". $feedObject->getEid()."'>".$feedObject->getShortDescription()."</a>.";
		//echo '<br /> at '.$feedObject->getDate()->format('m/d');
		echo '<br /><span>on '.$feedObject->getDate()->format('F jS, Y h:i A').'</span></div>';
	}
	
	public function getFriendAcceptFeedMessage(FeedObject $feedObject){
		$fid = $feedObject->getFid();
		echo "<img style='float: left; margin-right: 8px; margin-top: 1px;' src='/images/placeholder.png' width='30' height='30'/>";
		echo "<div class='individual-object'>You and <a href='/profile/public/uid/{$fid}'> ".addslashes($feedObject->getFirstName())." ".addslashes($feedObject->getLastName())."</a> became friends.";
		echo '<br /> <span>'.$feedObject->getDate()->format('F jS, Y h:i A').'</span></div>';
	}

}
// DisplayFeed could instead be FeedConstructor a set of algorithms abstract which are inherited by EventFeedConstructor or 
//GeneralFeedConstructor, DisplayEvent and DisplayGeneral both call different feeds based on the subclassed constructor it calls
//you could even potentially merge generalfeed and eventfeed into one construct
