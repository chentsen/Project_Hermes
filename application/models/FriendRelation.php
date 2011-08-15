sh<?php
use Documents\FriendRequest;
use Documents\User;
use Documents\Feed\GeneralFeed;
class Application_Model_FriendRelation{
	private $currentUser;
	
	public function __construct($identity){
		
    	$container = Zend_Registry::get('Wildkat\DoctrineContainer');
    	$this->dm = $container->getDocumentManager('default');
		$user = $this->dm->getRepository('Documents\User')->findOneByEmail($identity);
		$this->currentUser = $user;
	}
	private function addFriend(User $friend){
		//add to requestee's list and requester's list as well
		$friend->addFriend($this->currentUser);
		$this->currentUser->addFriend($friend);
		//make sure friendship doesn't already exit
	}
	private function removeFriend(User $friend){
		//find the friend and remove from both stacks, the friend and them as well.
	}
	public function createFriendRequest($friendIdentity){
		
		$friendUser = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$friendIdentity));
	//	echo $friendUser->getEmail();
		//echo $friendUser;
		$friendRequest = $this->dm->getRepository('Documents\FriendRequest')->findOneBy(array('requester.$id'=>$friendUser->getUid(),'requestee.$id'=>$this->currentUser->getUid()));
	
		$friendRequest2 = $this->dm->getRepository('Documents\FriendRequest')->findOneBy(array('requester.$id'=>$this->currentUser->getUid(),'requestee.$id'=>$friendUser->getUid()));
		
	
		//if this request doesn't already exist between these two people..figure out how to do more efficiently later
		if($friendUser && !$friendRequest && !$friendRequest2 && ($friendIdentity != $this->currentUser->getEmail()) ){
			if(!$this->isFriend($friendIdentity)){
					$friendRequest = new FriendRequest($this->currentUser, $friendUser);
					$this->dm->persist($friendRequest);
					//add this event to both peoples feeds
					$this->dm->flush();
					return true;
				}else return false;	
		}
		
		//tomorrow 1 test isFriend is working 2create an accept friend request page 3 and a reject friend page 4 create addFriendRejectFriend implementation
	}
	public function acceptFriendRequest(FriendRequest $friendRequest){
		$this->addFriend($friendRequest->getRequester());
		$this->addToGeneralFeed($friendRequest->getRequester(), $this->currentUser);
		$this->addToGeneralFeed($this->currentUser, $friendRequest->getRequester());
		$this->dm->remove($friendRequest);
		$this->dm->flush();
	}
	public function rejectFriendRequest(FriendRequest $friendRequest){
		$this->dm->remove($friendRequest);
		$this->dm->flush();
		//remove friend request and do nothing
	}
	public function getRequestList(){
		$query = $this->currentUser->getUid();
		$requestList = $this->dm->getRepository('Documents\FriendRequest')->findBy(array('requestee.$id'=>$query));
		
 		
		echo $query;
		//print_r($requestList);
		//echo $this->currentUser->getUid();
		//echo $requestList->count();
		
		if($requestList->count()>0)
			return $requestList;
		else 				
			return null;
	
	}
	public function getFriendList(){
		$friendList = $this->currentUser->getFriends();
		return $friendList;

	}
	public function isFriend($friendIdentity){
		$friends = $this->currentUser->getFriends();
		foreach($friends as $friend){
			if($friend->getEmail() == $friendIdentity){
				return true;
			}
		}
		return false;
	}
	private function addToGeneralFeed(Documents\User $user, Documents\User $otherUser){
		$generalFeed = $user->getGeneralFeed();
		if(!$user->getGeneralFeed()){
			$generalFeed = new GeneralFeed($user);
			$user->setGeneralFeed($generalFeed);
		}
		$inputs = array(
  					'lastName'=>$otherUser->getLastName(),
  					'firstName'=>$otherUser->getFirstName(),
  					'date'=>new \DateTime("now"),
  					'email'=>$otherUser->getEmail()
  					);
  		//print_r($inputs);
		$generalFeedModel = new Application_Model_Feed_GeneralFeedModel($generalFeed);
		$generalFeedObject = $generalFeedModel->createFriendAcceptFeedObject($inputs);
		$generalFeedModel->push($generalFeedObject);
		$generalFeedModel->sort();
		$this->dm->persist($generalFeedModel->getFeed());
		$this->dm->persist($user);
	}
	
}