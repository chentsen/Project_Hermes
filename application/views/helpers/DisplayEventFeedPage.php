<?php

use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;
class Zend_View_Helper_DisplayEventFeedPage extends Application_View_Helper_DisplayFeed{
	public function DisplayEventFeedPage($identity){
		$user = Zend_Registry::get("Wildkat\DoctrineContainer")->getDocumentManager('default')->getRepository('Documents\User')->findOneBy(array("email"=>$identity));
		$feed = $user->getEventFeed();
		
		$eventFeedModel = new Application_Model_Feed_EventFeedModel($feed);
		echo "<ul class = 'eventFeed'>";
		
		if( $eventFeedModel->getFeed()){
			 $feed = $eventFeedModel->getFeed();
			 $feedObjects = $feed->getFeedObjects();
			 foreach($feedObjects as $feedObject){
			 	
			 	//echo "<ul class= 'event-object'>";
				if(!$feedObject->getHidden()){
					echo '<li class = "single-event">';
                                        
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject, $identity);	
					
                                        echo '</li>';
				}
			 	echo "</ul>";
				
			 }		
		} else {
            echo '<div class="none-singleFound"><h1>No events yet<br/>Why don\'t you create one';
                            echo ' <a href="#" onclick="Dialog.showDialog({elementSelector:\'#event_ajax_form\',func:Dialog.loadEventDatePicker})">here</a>?</h1></div>';
        }
		
		//echo "</ul>";
	}
	//subclassed so we can construct our own custom feed message for events..
	public function getEventFeedMessage(FeedObject $feedObject){
            $eventModel = new Application_Model_EventModel($event->result);
           
           /* if ($feedObject->getCreator()->getEmail())
            {
                
                echo "<a href = '/event/index/eid/". $feedObject->getEid()."'>";
                echo 'Event Creator</a>';
               
            }*/
		    $date = new DateTime();
		
	
            
            if($feedObject->getEvent())
                {
					echo "<div class='event_header'><h1 class='event_title'>".$feedObject->getEvent()->getCreator()->getFirstName()." ".$feedObject->getEvent()->getCreator()->getLastName()." wants to ".$feedObject->getShortDescription()."</h1></div>";
					echo "<div class='event_main'><div class='event_img'>";
					echo "<img src='/img/profile-pic/uid/".$feedObject->getEvent()->getCreator()->getEmail()."' height='180' width='180' /></div>";
					echo "<div class='event_right'><div class='event_self'>";
					if ($eventModel->isEventCreator($identity, $creator))
					{ echo "Event Creator";}
					else {echo "Event Member";}
					echo "</h2>";
					echo '<div class="event_date"><h4>';
					if( $feedObject->getDate()->format('M d, Y') == $date->format('M d, Y'))
					{ echo "Event is today";}
					else if ($date->getTimeStamp() < $feedObject->getDate()->getTimestamp())
					{ echo "Event has not begun";}
					else 
					{ echo "Event has ended";}
					echo '</h4></div>';
					echo '<div class="event_date"><h4>'.$feedObject->getDate()->format('M d, Y').'</h4></div>';
					
					echo "<div class='event_location'><h4>".$feedObject->getEvent()->getLocation()."</h4></div>
							<div class='event_location'><h4>".$feedObject->getEvent()->getLongDescription()."</h4></div>
					</div></div>";			
				
				}
				
	}
}