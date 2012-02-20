<?php

class Zend_View_Helper_DisplayAttendingList extends Zend_View_Helper_Abstract{
	
	public function DisplayAttendingList($event){
		$attendingList = $event->getMembers();
		echo '<div class = "attendingList">';
		foreach($attendingList as $user){
			$eid = $event->getEid();
			$uid = $user->getUid();
			echo '<div class="attending-item attending-item-'.$uid.'">';
			echo "<a href='/profile/public/uid/{$user->getUid()}'>";
                        echo "<img src='/img/profile-pic/uid/{$user->getUid()}' height=100  width=100/></a>";
			echo "<div class='attending-details'>{$user->getFirstName()} is attending.</div>";
			//echo "<div class='event_allow'><a onclick=\"Event.processJoinRequest('{$eid}',{$uid},'y')\">Accept</a> | <a onclick = \"Event.processJoinRequest('{$eid}',{$uid},'n')\">Ignore</a></div>";
			echo '</div>';
		}
		echo '</div>';
		
	}
    
    public function DisplayMemberList($event){
		$attendingList = $event->getMembers();
		echo '<div class = "attendingList">';
		foreach($attendingList as $user){
			$eid = $event->getEid();
			$uid = $user->getUid();
			echo '<div class="attending-item attending-item-'.$uid.'">';
			echo "<a href='/profile/public/uid/{$user->getUid()}'>";
                        echo "<img src='/img/profile-pic/uid/{$user->getUid()}' height=100  width=100/></a>";
			echo "<div class='attending-details'>{$user->getFirstName()}</div>";
			
			echo '</div>';
		}
		echo '</div>';
		
	}
    
    public function DisplayPublicList($event){
		$attendingList = $event->getMembers();
		echo '<div class = "attendingList">';
		foreach($attendingList as $user){
			$eid = $event->getEid();
			$uid = $user->getUid();
			
			echo "<a href='/profile/public/uid/{$user->getUid()}'>";
                        echo "<img src='/img/profile-pic/uid/{$user->getUid()}' height=100  width=100/></a>";
			
		}
		echo '</div>';
		
	}
	
}