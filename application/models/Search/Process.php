<?php
use Documents\User;
use Documents\Event;
class Application_Model_Search_Process{
	private $dm;
	/**
	 * 
	 * returns an object corresponding to the type which was found.
	 * 
	 */
	public function __construct($dm){
		$this->dm = $dm;
	}
	public function process($document){
		if($document['users_email']!=''){
			//echo 'FOUND A USER';
			return $this->processUsers($document);
		}
		if($document['event_shortDescription']!=''){
		//	echo 'FOUND A EVENT';
			return $this->processEvents($document);
		}
	}
	
	private function processUsers($document){
		try{
			//var_dump($document);
			$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$document['users_email']));
			if($user){
				//echo '<br>'.$user->getEmail();
				return $user;			
			}
		}catch(Exception $ex){
			echo 'FAILED';
		}

	}
	private function processEvents($document){
		
		//$event = null;
		//echo $document['id'];
		//echo $document['event_location'];
		
		$event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$document['id']));
		
		
		//echo $event->getCreator()->getFirstName();
		//print_r($event);
		return $event;
	}
}