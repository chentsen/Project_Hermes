<?php
class Zend_View_Helper_DisplayFriendsPage extends Zend_View_Helper_Abstract{
	//eventually incorporate pagination
	private $friendRelation;
	public function DisplayFriendsPage($identity){
		$this->friendRelation = new Application_Model_FriendRelation($identity);
		if($this->friendRelation){
			$list = $this->friendRelation->getFriendList();
			echo '<div id = "">';
			echo '<ul>';
			$i = 0;
			if($list){
				foreach($list as $friend){
					
					
                                        echo '<li class="friend_list"><div class="friend_pic">';
                                        echo "<a href='/profile/public/email/{$friend->getEmail()}'>";
                                        echo "<img src='/img/profile-pic/uid/{$friend->getEmail()}' height=100  width=100/></a></div><div class='friend_name'>";
										
                                       
					echo "{$friend->getFirstName()} " . substr($friend->getLastName(),0,1);
					echo "<div class='friend-city'>{$friend->getCity()}</div>";
					echo '</div></li>';
					
					
					if (++$i == 9) break;
				}				
			}else 'You have no friends yet, add some!';
			echo '</ul>';
			if ($i >= 9) {
						echo '<a class="view-friends" href="friend">View All Friends</a>';
						
			}
			echo '</div>';
		}
	}
	
	
}