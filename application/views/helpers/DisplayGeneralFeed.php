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
		echo "<div class = 'generalFeed'>";
		
		if( $generalFeedModel->getFeed()){
			 $feed = $generalFeedModel->getFeed();
			 $feedObjects = $feed->getFeedObjects();
			 foreach($feedObjects as $feedObject){
			 	
			 	echo "<div class = 'generalFeedObject'>";
				if(!$feedObject->getHidden()){
					echo '<p>';
					//print_r($feedObject);
					$this->constructFeedMessage($feedObject);	
					echo '</p>';
				}
			 	echo "</div>";
			 }		
		} else {
				echo "<h1>No activy found</h1>";
		}
		echo "</div>";
	}
	
}