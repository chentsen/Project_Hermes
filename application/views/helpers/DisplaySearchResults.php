<?php
class Zend_View_Helper_DisplaySearchResults extends Zend_View_Helper_Abstract{
	public function DisplaySearchResults($results,$identity){
		//events and friends should return information that is first preprocessed for the state of each
		//based on object that is found, pass it into other functions that process and then return the div of each.
		//For now these functions can reside in DisplaySearchResults..in the future, they should be abstracted out so that everything can use them.
		if($results){
			//echo 'COUNT IS = '.count($results);
			
			if(count($results['eventResults'])>0){
				foreach($results['eventResults'] as $object){
					$this->printEventResult($object,$identity);
				}
			}
			if(count($results['userResults'])>0){
				//print_r($results['userResults']);
				//var_dump($results['userResults']);
				foreach($results['userResults'] as $object){
					echo 'second loop';
					$this->printUserResult($object,$identity);
				}
			}	
		}else return;	
	}
	private function printEventResult(Documents\Search\EventResult $event,$identity){
		$returnString = ' ';
		echo "<p><div class = 'event_result'>";
		echo '<div class = "matchingTags">';
			echo "You and {$event->result->getCreator()->getFirstName()} (The event creator) have {$event->getCount()} tags in common! <br />";
			echo "You both like:";
			foreach($event->match as $match){
				echo "<div class='matchedTag'>";
					echo $match->getTagName();
				echo "</div>";
			}
		echo '</div>';
		
		//are you creator or member? omit interested in
		echo "{$event->result->getCreator()->getFirstName()} wants to : ".$event->result->getShortDescription();
		echo "<br /> <a href = '/event/index/eid/{$event->result->getEid()}'> Go to Event Page </a>";
		//echo $identity;
		if(!($identity==$event->result->getCreator()->getEmail())){
			$eventModel = new Application_Model_EventModel($event->result);
			if(!$eventModel->isMember($identity,$event->result->getMembers())&&
	  			(!$eventModel->isMember($identity,$event->result->getWaitingList()))){
				echo "<div class = 'event_interested'>";
				echo "<a href = '/event/request/eid/{$event->result->getEid()}'>I'm down'</a>";
				echo "</div>";
			}
		}	
		
		//view event page
		
		echo "</p></div>";
		//return $returnString;
	}
	private function printUserResult(Documents\Search\UserResult $user,$identity){
		if($user->result->getEmail()!=$identity){
			echo "<p><div class = 'user_result'>";
			$friendRelation = new Application_Model_FriendRelation($identity);
			echo '<div class = "matchingTags">';
			echo "You and {$user->result->getFirstName()} have {$user->getCount()} tags in common! <br />";
			echo "You both like:";
			if($user->match){
				foreach($user->match as $match){
					echo "<div class='matchedTag'>";
						echo $match->getTagName();
					echo "</div>";
				}
			}
			echo '</div>';
			if(!$friendRelation->isFriend($user->result->getEmail())){
				echo "<div class = 'user_addFriend'>";
				echo "Add {$user->result->getFirstName()} as a friend! <br />";
				echo "<a href = /friend/friendRequest/requestee/{$user->result->getEmail()}> Add </a>";
				echo "</div>";
			}
			echo "<div class = 'user_viewProfile'>";
				echo "{$user->result->getFirstName()}";
				echo "<br />";
				$email = $user->result->getEmail();
				echo "<a href = '/profile/public/email/{$email}'> profile </a>";
			echo "</div>";
			//check if currently friends- are we? omit add as friend
			//view profile
			echo "</p></div>";
		}
	//	return returnString		
	}
}?>
