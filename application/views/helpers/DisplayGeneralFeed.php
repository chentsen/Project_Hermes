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
			 
			 for($i = 0; $i < 6; $i++) {
				if($i < 5) {
						echo "<li class = 'notification-object'>";
						if(!$feedObjects[$i]->getHidden()) {
								
								$this->constructFeedMessage($feedObjects[$i], $identity);
						}
						echo "</li>";
				} else {
						echo "<li class='view-notifications'>View all notifications</li>";
				}
			 }
			 
			 echo '</ul>';
		} else {
				echo "<a class='so-ronery'>No activity found</div>";
		}
		echo "</div>";
	}
	
}