<?php
use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;

class Zend_View_Helper_DisplayGeneralFeed extends Application_View_Helper_DisplayFeed{
	
	public function DisplayGeneralFeed($identity){
		$user = Zend_Registry::get("Wildkat\DoctrineContainer")->getDocumentManager('default')->getRepository('Documents\User')->
			findOneBy(array("email"=>$identity));
		$feed = $user->getGeneralFeed();
		
		$generalFeedModel = new Application_Model_Feed_GeneralFeedModel($feed);
		
				echo '<div class="notifications">';
		if( $generalFeedModel->getFeed()){
				echo "<ul class = 'notification-list'>";
			 $feed = $generalFeedModel->getFeed();
			 $feedObjects = $feed->getFeedObjects();
			 foreach($feedObjects as $feedObject){
			 	
			 	echo "<li class = 'notification-object'>";
				if(!$feedObject->getHidden()){
					
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject);	
					
				}
			 	echo "</li>";
			 }
			 echo '</ul>';
		} else {
				echo "<h3>No activity found</h3>";
		}
		echo "</div>";
	}
	
}