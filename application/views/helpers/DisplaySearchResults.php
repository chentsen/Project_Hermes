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
		echo "<div class = 'event_result'>";
		echo '<div class = "matchingTags">';
                echo '<div class="common_value">';
				echo "<a href = '/event/index/eid/{$event->result->getEid()}'>";
				echo '<div class="common_number">';
			echo "{$event->getCount()} ";
                         echo '</div></a><div class="in_common"><h3>Tags in Common</h3></div></div>';
                         echo "<div class='user_info'><h2>{$event->result->getCreator()->getFirstName()} wants to ".$event->result->getShortDescription()."</h2>";
                        
                        
			
                         //echo $identity;
                        if(!($identity==$event->result->getCreator()->getEmail())){
                                $eventModel = new Application_Model_EventModel($event->result);
                                if(!$eventModel->isMember($identity,$event->result->getMembers())&&
                                        (!$eventModel->isMember($identity,$event->result->getWaitingList()))){
                                        
                                        echo "<a class='join_event remove-anchor' href = '/event/request/eid/{$event->result->getEid()}'>I'm down</a>";
                                    
                                }
                        }	

                          echo "<a class='view_event' href = '/event/index/eid/{$event->result->getEid()}'>view event details</a></div>";
                         
                         echo "<div class='user_like'>You both like</div>";
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
		
		
		
		
		//view event page
		
		echo "</div>";
		//return $returnString;
	}
	private function printUserResult(Documents\Search\UserResult $user,$identity){
				
				
				
            if($user->result->getEmail()!=$identity){
				
			echo "<div class = 'user_result'>";
			$friendRelation = new Application_Model_FriendRelation($identity);
			
				$email = $user->result->getEmail();			
			//echo "You and {$user->result->getFirstName()} have {$user->getCount()} tags in common! <br />";

                        //echo '<div class="indiv-result" style="">';
						echo "<a href='/profile/public/email/{$email}'>";

						echo '<img src="/img/profile-pic/uid/'.$email.'" height=75  width=75/ </a>';
						echo "<div class='user-info' style='float:right; width: 550px; border-bottom: 1px solid black;'>
								<div class='search-name'><a href = '/profile/public/email/{$email}'>{$user->result->getFirstName()} {$user->result->getLastName()}</a></div>
								<div class='search-city'>{$user->result->getCity()}</div>
								<div class='search-common-tags'>{$user->getCount()} tags in common</div>";
		                                            
			if(!$friendRelation->isFriend($user->result->getEmail()) && $friendRelation->isRequested($user->result->getEmail())){
				echo "<div class ='add-friend'>";
				//echo "Add {$user->result->getFirstName()} as a friend! <br />";
				
				echo "<a class='remove-anchor' href = /friend/friendRequest/requestee/{$user->result->getEmail()}>add</a>";
				
				echo "</div>";
			}
			echo "</div>";

			//check if currently friends- are we? omit add as friend
			//view profile
			
		
                        echo "<div class='user_like'>You both like</div>";
                        
			if($user->match){
				if(count($user->match > 1)){
					foreach($user->match as $match){
						echo "<div class='matchedTag'>";
							echo $match->getTagName();
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
