<?php

use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
class Zend_View_Helper_DisplayEventFeed extends Application_View_Helper_DisplayFeed{
	public function DisplayEventFeed($identity, $length = null){
		$user = Zend_Registry::get("Wildkat\DoctrineContainer")->getDocumentManager('default')->getRepository('Documents\User')->findOneBy(array("email"=>$identity));
		$feed = $user->getEventFeed();
		
		$eventFeedModel = new Application_Model_Feed_EventFeedModel($feed);
		echo "<ul class = 'eventFeed'>";
		
		if( $eventFeedModel->getFeed()){
			 $feed = $eventFeedModel->getFeed();
			 $feedObjects = $feed->getFeedObjects();
			 $length = ($length) ? $length : count($feedObjects);
			 $display_length = min(count($feedObjects),$length);
			 for($i = 0; $i < $display_length ; $i++){
				$feedObject = $feedObjects[$i];
			 	echo "<li class = 'eventFeedObject'>";
				if(!$feedObject->getHidden()){
					echo '<p>';
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject);						
                                        echo '</p>';
				}
			 	echo "</li>";
			 }		
		}
		if($i >= $length && $length > 4)
			$html = '<a class="view-events" href="/event-list">View all events</a>';
		if($i == 0 && $length > 4)
			$html = '<a class="so-ronery">You have no events right now.</a>';
		else if ($i == 0 && $length <4)
		   $html = 'Not attending any events yet';
		echo $html;
		echo "</ul>";
	}
	//subclassed so we can construct our own custom feed message for events..
	public function getEventFeedMessage(FeedObject $feedObject){
            $eventModel = new Application_Model_EventModel($event->result);
           
           /* if ($feedObject->getCreator()->getEmail())
            {
                
                echo "<a href = '/event/index/eid/". $feedObject->getEid()."'>";
                echo 'Event Creator</a>';
               
            }*/
            //echo "<a href = '/event/index/eid/". $feedObject->getEid()."'>";
            if($feedObject->getEvent())
               {
				echo '<img style="float: left;" src="/images/meet-people.png" width="50" /><div class="mini-feed">';
                echo '<h4><a href = \'/event/index/eid/'. $feedObject->getEid().'\'>'.$feedObject->getShortDescription().' @ '.$feedObject->getEvent()->getLocation().'</a></h4>';                
				echo 'on '.$feedObject->getDate()->format('m/d');
                echo '</div>';
			   }
	}
}