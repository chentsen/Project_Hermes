<?php
/**
 * 
 * Takes a specific event and displays everyone on the waiting list
 * @author chentsen
 *
 */
class Zend_View_Helper_DisplayInterestedList extends Zend_View_Helper_Abstract{
	
	public function DisplayInterestedList($event){
		$waitingList = $event->getWaitingList();
		echo '<div class = "waitingList">';
		foreach($waitingList as $user){
			echo "<div class = 'waitingList_item'>";
			echo "{$user->getFirstName()} {$user->getLastName()} is interested in your event.<br />";
			echo "<a href = '/event/response/response/y/eid/{$event->getEid()}/email/{$user->getEmail()}'>accept</a>|<a href = '/event/response/reponse/y/eid/{$event->getEid()}/email/{$user->getEmail()}'>ignore</a><br />";
			echo "</div>";
		}
		echo '</div>';
		
	}
	
}