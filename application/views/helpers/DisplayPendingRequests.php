<?php
class Zend_View_Helper_DisplayPendingRequests extends Zend_View_Helper_Abstract{
	//eventually incorporate pagination
	
	public function DisplayPendingRequests($identity){
		//can possibly pass this object from calling controller, view..
		$this->friendRelation = new Application_Model_FriendRelation($identity);
		$friendRequests = $this->friendRelation->getRequestList();

		//echo 'found friernd';
		if($friendRequests){
			//print_r($friendRequests);
			foreach($friendRequests as $friendRequest){
				$lastName = substr($friendRequest->getRequester()->getLastName(),0,1);
				echo "<li class='friend-requests'><div class='friend-request-message'><a class='friend-request-name' href='/profile/public/uid/{$friendRequest->getRequester()->getUid()}'>{$friendRequest->getRequester()->getFirstName()} {$lastName}.</a> would like to be your friend.</div>";
				echo "<div class='accept-ignore'><a class='friend-request-accept' href = '/friend/respond_friend_request/accept/yes/rid/{$friendRequest->getRequestId()}'> Accept </a>
					  <a class='friend-request-ignore' href = '/friend/respond_friend_request/accept/no/rid/{$friendRequest->getRequestId()}'> Ignore </a></div></li>";
			}
		}
		else echo 'You have no pending friend requests.';
	}
}