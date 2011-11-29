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
					echo '<li>';
                                        
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject);	
					
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
            echo "Place: <a href = '/event/index/eid/". $feedObject->getEid()."'>";
            if($feedObject->getEvent())
                
                echo $feedObject->getEvent()->getLocation().'</a>';                
				echo '<br />Date: '.$feedObject->getDate()->format('M d, Y');
                echo '<br/>Activity: '.$feedObject->getShortDescription();
                //echo '<br />More Info: '. $feedObject->getLongDescription();
	}
}