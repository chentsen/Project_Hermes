<?php
class Zend_View_Helper_DisplayFriends extends Zend_View_Helper_Abstract{
	//eventually incorporate pagination
	private $friendRelation;
	public function DisplayFriends($identity){
		$this->friendRelation = new Application_Model_FriendRelation($identity);
		if($this->friendRelation){
			$list = $this->friendRelation->getFriendList();
			echo '<div id = "friendsList">';
			echo '<ul>';
			$i = 0;
			if($list){
				foreach($list as $friend){
					
					
                                        echo '<li class="friend_list"><div class="friend_pic">';
                                        echo "<a href='/profile/public/uid/{$friend->getUid()}'>";
                                        echo "<img src='/img/profile-pic/uid/{$friend->getUid()}' height=75  width=75/></a></div><div class='friend_name'>";
                                       
					echo "{$friend->getFirstName()} " . substr($friend->getLastName(),0,1) . ".";
					echo '</div></li>';
					
					
					if (++$i == 9) break;
				}				
			} else 'You have no friends yet.';
			echo '</ul>';
			if ($i >= 9) {
						echo '<a class="view-friends" href="friend">View All Friends</a>';
						
			}
			if ($i == 0) {
				echo '<a href="#" class="so-ronery">You have no friends yet.</a>';
			}
			echo '</div>';
		}
	}
	
	
}