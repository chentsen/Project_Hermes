<?php
class Zend_View_Helper_DisplayPendingRequests extends Zend_View_Helper_Abstract{
	//eventually incorporate pagination
	
	public function DisplayPendingRequests($identity){
		//can possibly pass this object from calling controller, view..
		$this->friendRelation = new Application_Model_FriendRelation($identity);
		$friendRequests = $this->friendRelation->getRequestList();
		echo '<div id = "friendRequests">';
		
		//echo 'found friernd';
		if($friendRequests){
			//print_r($friendRequests);
			foreach($friendRequests as $friendRequest){
				echo "<div>{$friendRequest->getRequester()->getEmail()} would like to be your friend.";
				echo "<a style='margin: 0; padding: 0;width: 100%;float: left;' href = '/friend/respond_friend_request/accept/yes/rid/{$friendRequest->getRequestId()}'> Accept </a>|
					  <a style='margin: 0; padding: 0; width: 100%;float: left;' href = '/friend/respond_friend_request/accept/no/rid/{$friendRequest->getRequestId()}'> Ignore </a></div>";
			}
		}
		else echo 'You have no pending friend requests.';
		
		echo '</div>';
	}
}