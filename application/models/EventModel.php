	<?php
use Documents\Feed\EventFeed;
use Documents\Feed\GeneralFeed;
use Documents\Event;


class Application_Model_EventModel{
	private $event;
	private $dm;
	public function __construct($event = null){
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$this->event = $event;
	}
	public function createEvent($raw){
		//must use named indexes to work correctly
		//print_r($raw);
		$location = $raw['createEvent_location'];
		$shortDescription = $raw['createEvent_shortDescription'];
		$longDescription = ($raw['createEvent_longDescription'] == '') ? null : $raw['createEvent_longDescription'];
		$private = (($raw['createEvent_private'] == 'y') ? true : false);
		
		$dateArray = explode('/',$raw['createEvent_date']);
		//var_dump($dateArray);
		$date = new DateTime();
		//$date->setDate($year, $month, $day)
		
		$date->setDate($dateArray[2],$dateArray[1],$dateArray[0]);	
		$creator = $this->dm->getRepository('Documents\User')->findOneBy(array('email' => $raw['credential']));
		//we have to randomize to avoid flushing twice
		$id = uniqid(rand(),false);
		//echo 'USERS NAME IS '.$creator->getEmail(); 
		$options = array(
							'location'=> $location,
							'shortDescription'=> $shortDescription,
							'longDescription'=>$longDescription,
							'private'=>$private,
							'creator'=>$creator,
							'date'=>$date,
							'id' => $id
						);
		
		
		$this->event = new Event($options);
		//echo 'ID is '. $this->event->getEid();
		if($this->event){
			//print_r($options);	
			$this->dm->persist($this->event);	
			$this->dm->persist($this->event->getWall());
			$eventFeedObject = $this->addToEventFeed($creator);
			//echo 'ADDING';
			$this->addToGeneralFeed($creator,$eventFeedObject);
			$this->dm->flush();		
			return true;
		}
		else{
			return false;	
		}
		
		
	} 
  public function isMember($identity,$members){
  		
		foreach($members as $member){
			if($member->getEmail() == $identity){
				return true;
			}
		}
	return false;
  }	
  
  public function attendRequest($identity){
  	//if we arent in the member list and we arent in the interested list
  	//echo 'IN HERE';
  	echo $this->event->getCreator()->getEmail();
  	echo $identity;
  	if(!($identity==$this->event->getCreator()->getEmail())){
	  //	echo $this->isMember($identity, $this->event->getMembers());
  		if((!$this->isMember($identity, $this->event->getMembers()))&&
	  		(!$this->isMember($identity,$this->event->getWaitingList())))
	  	{
		  	
	  		$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$identity));
		  	
		  	$this->dm->persist($this->event);
		  	$this->event->addWaitingList($user);
		  	$this->dm->flush();
			return true;
	  	}
  	}else return false;
  }
  public function acceptRequest(Documents\User $user){
	if(!$this->isMember($user->getEmail(),$this->event->getMembers())&&
		$this->isMember($user->getEmail(),$this->event->getWaitingList())){
			$this->event->addMember($user);
			$user->addEvent($this->event);
			$this->event->removeWaitingList($user);
			$this->dm->persist($this->event);
			$this->dm->persist($user);
			$this->addToEventFeed($user);
			$this->dm->flush();
			
		}
  	//add user to current list(both)
	//remove him from waiting list
  }
  public function rejectRequest(Documents\User $user){
  	if($this->isMember($user->getEmail(),$this->event->getWaitingList())){
  		$this->event->removeWaitingList($user);
  		$this->dm->persist($this->event);
  		$this->dm->flush();	
  	}
  	//just remove user from waiting list
  }
  //adds event to user's feed
  private function addToEventFeed($user){
  	$eventFeed = $user->getEventFeed();
  	//if the feed exists then add to it
  	//if feed doesn't exist then create a new one and link to current user
  	if(!$eventFeed){
  		$eventFeed = new EventFeed($user);
  		$user->setEventFeed($eventFeed);
  	}
  	
  	//print_r($eventFeed);
  	$eventFeedModel = new Application_Model_Feed_EventFeedModel($eventFeed);
  	$inputs = array(
  					'eid'=>$this->event->getEid(),
  					'shortDescription'=>$this->event->getShortDescription(),
  					'date'=>$this->event->getDate(),
  					'creator'=>$this->event->getCreator()
  					);
  	$eventFeedObject = $eventFeedModel->createEventFeedObject($inputs);
  	$eventFeedModel->push($eventFeedObject);
  	$eventFeedModel->sort();
  	$this->dm->persist($eventFeedModel->getFeed());
  	$this->dm->persist($user);
  	return $eventFeedObject;
  }
  private function addToGeneralFeed(Documents\User $creator,$eventFeedObject){
  	//echo 'BEING CALLED2';
  	$friends = $creator->getFriends();
  	//echo ''
  	//iterate through friends and add the feed, may want to do observer pattern
  	foreach($friends as $friend){
	  	echo 'FRIEND IS'. $friend->getFirstName();
  		$generalFeed = $friend->getGeneralFeed();
	  	if(!$generalFeed){
	  		echo 'FEEDS NEW';
	  		$generalFeed = new GeneralFeed($friend);
	  		$friend->setGeneralFeed($generalFeed);
	  	}
	  	$generalFeedModel = new Application_Model_Feed_GeneralFeedModel($generalFeed);
  		$generalFeedModel->push($eventFeedObject);
  		$generalFeedModel->sort();
  		$this->dm->persist($generalFeedModel->getFeed());
  		$this->dm->persist($friend);
  	}
  }
  

}