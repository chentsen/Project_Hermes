<?php
class Zend_View_Helper_DisplaySearchResults extends Zend_View_Helper_Abstract{
	public function DisplaySearchResults($results,$identity){
		//events and friends should return information that is first preprocessed for the state of each
		//based on object that is found, pass it into other functions that process and then return the div of each.
		//For now these functions can reside in DisplaySearchResults..in the future, they should be abstracted out so that everything can use them.
		if($results){
			//echo 'COUNT IS = '.count($results);
			foreach($results as $object){
				
				if($object instanceof Documents\Event){
					//echo 'in event';
					$this->printEventResult($object,$identity);
				}	
				if($object instanceof Documents\User){
					//echo 'in user';
					$this->printUserResult($object,$identity);
				}	
	
			}
		}else return;	
	}
	private function printEventResult(Documents\Event $event,$identity){
		$returnString = ' ';
		echo "<p><div class = 'event_result'>";
		//are you creator or member? omit interested in
		echo "{$event->getCreator()->getFirstName()} wants to : ".$event->getShortDescription();
		echo "<br /> <a href = '/event/index/eid/{$event->getEid()}'> Go to Event Page </a>";
		//echo $identity;
		if(!($identity==$event->getCreator()->getEmail())){
			$eventModel = new Application_Model_EventModel($event);
			if(!$eventModel->isMember($identity,$event->getMembers())&&
	  			(!$eventModel->isMember($identity,$event->getWaitingList()))){
				echo "<div class = 'event_interested'>";
				echo "<a href = '/event/request/eid/{$event->getEid()}'>I'm down'</a>";
				echo "</div>";
			}
		}	
		
		//view event page
		
		echo "</p></div>";
		//return $returnString;
	}
	private function printUserResult(Documents\User $user,$identity){
		if($user->getEmail()!=$identity){
			echo "<p><div class = 'user_result'>";
			$friendRelation = new Application_Model_FriendRelation($identity);
			if(!$friendRelation->isFriend($user->getEmail())){
				echo "<div class = 'user_addFriend'>";
				echo "Add {$user->getFirstName()} as a friend! <br />";
				
				echo "<a href = /friend/friendRequest/requestee/{$user->getEmail()}> Add </a>";
				echo "</div>";
			}
			echo "<div class = 'user_viewProfile'>";
				echo "{$user->getFirstName()}";
				echo "<br />";
				$email = $user->getEmail();
				echo "<a href = '/profile/public/email/{$email}'> profile </a>";
			echo "</div>";
			//check if currently friends- are we? omit add as friend
			//view profile
			echo "</p></div>";
		}
	//	return returnString;
		
	}
}