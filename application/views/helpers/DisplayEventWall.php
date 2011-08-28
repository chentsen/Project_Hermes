<?php
use Documents\Wall;

class Zend_View_Helper_DisplayEventWall extends Zend_View_Helper_Abstract{
	public function DisplayEventWall(Documents\Event $event, $identity){
		$eid = $event->getEid();
		$wall = $event->getWall();
		//echo 'the wall';
		echo '<div class = "wall">';
		foreach($wall->getWallPosts() as $wallPost){
			echo '<div class = "wallpost">';
			echo $wallPost->getUser()->getFirstName().' Said: '. $wallPost->getMessage();
			echo '<br />';
			//if this is my post then I should be able to delete it
			if($wallPost->getUser()->getEmail() == $identity){
				echo "<a href = /event/delete/postid/{$wallPost->getPostId}/eid/{$eid}>delete</a>";
			}
			echo '</div>';
		}
		//create a new form with $eid as input;
		$form = new Application_Form_Wall(array('eid'=>$eid));
		echo $form;
		echo '</div>';
	}
}