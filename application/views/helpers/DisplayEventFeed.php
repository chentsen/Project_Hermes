<?php

use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
class Zend_View_Helper_DisplayEventFeed extends Application_View_Helper_DisplayFeed{
	public function DisplayEventFeed($identity, $length = null){
		$user = Zend_Registry::get("Wildkat\DoctrineContainer")->getDocumentManager('default')->getRepository('Documents\User')->findOneBy(array("email"=>$identity));
		$feed = $user->getEventFeed();
		
		$eventFeedModel = new Application_Model_Feed_EventFeedModel($feed);
		echo "<div class = 'eventFeed'>";
		
		if( $eventFeedModel->getFeed()){
			 $feed = $eventFeedModel->getFeed();
			 $feedObjects = $feed->getFeedObjects();
			 $length = ($length) ? $length : count($feedObjects);
			 $display_length = min(count($feedObjects),$length);
			 for($i = 0; $i < $display_length ; $i++){
				$feedObject = $feedObjects[$i];
			 	echo "<div class = 'eventFeedObject'>";
				if(!$feedObject->getHidden()){
					echo '<p>';
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject);						
                                        echo '</p>';
				}
			 	echo "</div>";
			 }		
		}
		$html = ($i >= $length) ? '<a class="view-events" href="/event-list">View Events</a>' : '<a class="so-ronery">You have no events right now.</a>';
		echo $html;
		echo "</div>";
	}
	//subclassed so we can construct our own custom feed message for events..
	public function getEventFeedMessage(FeedObject $feedObject){
            $eventModel = new Application_Model_EventModel($event->result);
           
           /* if ($feedObject->getCreator()->getEmail())
            {
                
                echo "<a href = '/event/index/eid/". $feedObject->getEid()."'>";
                echo 'Event Creator</a>';
               
            }*/
            echo "<a href = '/event/index/eid/". $feedObject->getEid()."'>";
            if($feedObject->getEvent())
                
                    echo $feedObject->getEvent()->getLocation();                
		echo '<br />On '.$feedObject->getDate()->format('m/d');
                echo '<br/>@ '.$feedObject->getShortDescription();
                echo '</a>';
	}
}