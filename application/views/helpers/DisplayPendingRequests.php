<?php
class Zend_View_Helper_DisplayPendingRequests extends Zend_View_Helper_Abstract{
	//eventually incorporate pagination
	
	public function DisplayPendingRequests($identity){
		//can possibly pass this object from calling controller, view..
		$this->friendRelation = new Application_Model_FriendRelation($identity);
		$friendRequests = $this->friendRelation->getRequestList();
		echo '<div id = "friendRequests">';
		echo '<ul>';
		//echo 'found friernd';
		if($friendRequests){
			//print_r($friendRequests);
			foreach($friendRequests as $friendRequest){
				echo "<li>{$friendRequest->getRequester()->getEmail()} would like to be your friend";
				echo "<a href = '/friend/respond_friend_request/accept/yes/rid/{$friendRequest->getRequestId()}'> accept </a>|
					  <a href = '/friend/respond_friend_request/accept/no/rid/{$friendRequest->getRequestId()}'> ignore </a></li>";
			}
		}
		else echo 'You have no pending friend requests';
		echo '</ul>';
		echo '</div>';
	}
}