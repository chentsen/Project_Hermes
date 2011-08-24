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
			if($list){
				foreach($list as $friend){
                                        echo '<img src="images/placeholder.png"/>';
                                        echo '<li class="friend_name">';
					echo "{$friend->getFirstName()} {$friend->getLastName()}";
					echo '</li>';
				}				
			}else 'You have no friends yet, add some!';
			echo '</ul>';
			echo '</div>';
		}
	}
}