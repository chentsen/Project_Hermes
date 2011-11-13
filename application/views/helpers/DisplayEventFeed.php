<?php

use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
class Zend_View_Helper_DisplayEventFeed extends Application_View_Helper_DisplayFeed{
	public function DisplayEventFeed($identity, $length){
		$user = Zend_Registry::get("Wildkat\DoctrineContainer")->getDocumentManager('default')->getRepository('Documents\User')->findOneBy(array("email"=>$identity));
		$feed = $user->getEventFeed();
		
		$eventFeedModel = new Application_Model_Feed_EventFeedModel($feed);
		echo "<div class = 'eventFeed'>";
		
		if( $eventFeedModel->getFeed()){
			 $feed = $eventFeedModel->getFeed();
			 $feedObjects = $feed->getFeedObjects();
			 foreach($feedObjects as $feedObject){
			 	
			 	echo "<div class = 'eventFeedObject'>";
				if(!$feedObject->getHidden()){
					echo '<p>';
                                        
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject);	
					
                                        echo '</p>';
				}
			 	echo "</div>";
				if (++$i == $length) break;
			 }		
		}
		if ($i >= $length) {
						echo '<a class="view-events" href="event-list">View Events</a>';
						
			}
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