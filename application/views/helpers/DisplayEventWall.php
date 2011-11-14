<?php
use Documents\Wall;

class Zend_View_Helper_DisplayEventWall extends Zend_View_Helper_Abstract{
	public function DisplayEventWall(Documents\Event $event, $identity){
		$eid = $event->getEid();
		$wall = $event->getWall();
		//echo 'the wall';
		echo '<div class = "wall_add">';
		/*foreach($wall->getWallPosts() as $wallPost){
			echo '<div class="posts"><div class = "wallpost"><div class="wall_image"><img height="50" width="50"src="/images/placeholder.png" /><span>10</span></div>';
			echo '<div class="wall_name">'. $wallPost->getUser()->getFirstName().' says</div><div class="wall_text">'. $wallPost->getMessage().'';
			$postid = $wallPost->getPostID();
			//if this is my post then I should be able to delete it
			if($wallPost->getUser()->getEmail() == $identity){
				echo "<a onclick = 'Wall.deleteComment({eid:\"{$eid}\",postId:\"{$postid}\"})' href='#'>delete</a>";
			}
			echo '</div></div></div>';
		}*/
		//create a new form with $eid as input;
		$form = new Application_Form_Wall(array('eid'=>$eid));
		echo $form;
		echo '</div>';
	}
}