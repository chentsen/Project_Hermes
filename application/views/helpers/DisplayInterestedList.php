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
		foreach($waitingList as $user){
			$eid = $event->getEid();
			$uid = $user->getUid();
			echo '<div class="waiting-item waiting-item-'.$uid.'">';
			echo "<a href='/profile/public/uid/{$user->getUid()}'>";
                        echo "<img src='".Application_Model_Utils_ImageUtil::getProfilePicURL($user)."' height=70  width=70/></a>";
			echo "<div class='waiting-details'>{$user->getFirstName()} wants to join.</div>";
			echo "<div class='event_allow'><a onclick=\"Event.processJoinRequest('{$eid}',{$uid},'y')\">Accept</a>    <a onclick = \"Event.processJoinRequest('{$eid}',{$uid},'n')\">Ignore</a></div>";
			echo '</div>';
		}
		
	}
	
}