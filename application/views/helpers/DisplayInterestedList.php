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
			echo '<div class="waiting-item">';
			echo "<a href='/profile/public/uid/{$user->getUid()}'>";
                        echo "<img src='/img/profile-pic/uid/{$user->getUid()}' height=100  width=100/></a>";
			echo "<div class='waiting-details'>{$user->getFirstName()} wants to come.</div>";
			echo "<div class='event_allow'><a href = '/event/response/response/y/eid/{$event->getEid()}/email/{$user->getEmail()}'>Accept</a> | <a href = '/event/response/reponse/y/eid/{$event->getEid()}/uid/{$user->getUid()}'>Ignore</a></div>";
			echo '</div>';
		}
		echo '</div>';
		
	}
	
}