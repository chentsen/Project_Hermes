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
					$this->printUserResult($object,$identity);
				}
			}
                        if(count($results['userResults'])==0 && count($results['eventResults'])==0) {
                            echo '<div class="none-singleFound"><h1>No users or events found :(<br/>';
                            echo ' <a href="#" onclick="Dialog.showDialog({elementSelector:\'#event_ajax_form\',func:Dialog.loadEventDatePicker})">Create</a> an event to meet some!</h1></div>';
                        } else if (count($results['userResults'])==0) {
                            echo '<div class="none-singleFound"><h1>No users found :(<br/>Why don\'t';
                            echo ' <a href="#" onclick="Dialog.showDialog({elementSelector:\'#event_ajax_form\',func:Dialog.loadEventDatePicker})">Create</a> an event to meet some!</h1></div>';
                        } else if (count($results['eventResults'])==0) {
                            
                            echo '<div class="none-singleFound"><h1>No events found :(<br/>Why don\'t you create one';
                            echo ' <a href="#" onclick="Dialog.showDialog({elementSelector:\'#event_ajax_form\',func:Dialog.loadEventDatePicker})">here</a>?</h1></div>';
                        }
                           
                    }else {
                    
                    return;	}
	}
	private function printEventResult(Documents\Search\EventResult $event,$identity){
		$returnString = ' ';
		echo "<p><div class = 'event_result'>";
		echo '<div class = "matchingTags">';
			echo "You and {$event->result->getCreator()->getFirstName()} (The event creator) have {$event->getCount()} tags in common! <br />";
			echo "You both like:";
			if($event->match){
				if(count($event->match) > 1){
					foreach($event->match as $match){
						echo "<div class='matchedTag'>";
							echo $match->getTagName();
						echo "</div>";
					}
				}else{
					echo "<div class='matchedTag'>";
						echo $event->match[0]->getTagName();
					echo "</div>";
				}
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
			echo "<div class = 'user_result'>";
			$friendRelation = new Application_Model_FriendRelation($identity);
			
			//echo "You and {$user->result->getFirstName()} have {$user->getCount()} tags in common! <br />";
                        echo '<div class="common_value"><div class="common_number">';
                        echo "{$user->getCount()}";
                            
                        echo '</div><div class="in_common"><h3>Tags in Common</h3></div></div>';
			echo "<div class='user_info'><h2>{$user->result->getFirstName()}</h2>";
                        
			if(!$friendRelation->isFriend($user->result->getEmail())){
				echo "<div class = 'user_addFriend'>";
				//echo "Add {$user->result->getFirstName()} as a friend! <br />";
				echo "<a href = /friend/friendRequest/requestee/{$user->result->getEmail()}>add</a>";
				echo "</div>";
			}
			echo "<div class = 'user_viewProfile'>";
				
				$email = $user->result->getEmail();
				echo "<a href = '/profile/public/email/{$email}'>view profile</a>";
			echo "</div></div>";
			//check if currently friends- are we? omit add as friend
			//view profile
			
		
                        echo "<div class='user_like'>You both like</div>";
                        
			if($user->match){
				if(count($user->match > 1)){
					foreach($user->match as $match){
						echo "<div class='matchedTag'>";
							echo $match[0]->getTagName();
						echo "</div>";
					}
				}else if(count($user->match == 1)){
						echo "<div class='matchedTag'>";
						echo $match[0]->getTagName();
						echo "</div>";
					
                        	}
                                 
			}
                        else {
                           
                                    echo '<div class="noMatch">No Matching Tags</div>';
                             
                        }
			echo '</div>';
                } 
                
                            
	//	return returnString		
	}
}?>
