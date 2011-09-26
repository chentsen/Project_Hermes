<?php
class Zend_View_Helper_DisplayNewUserflow extends Zend_View_Helper_Abstract{
	public function DisplayNewUserflow($status){
		if($status == 0){
			echo '<h2>Complete your profile!</h2>';
			echo 'Take some time to answer some questions about yourself so you can start meeting people now!';
			echo '<a href ="/profile/questions"> Answer Now! </a>';
		}
		if($status < 4 && $status > 0){
			echo '<h2>Complete your profile!</h2>';
			echo 'complete the questions to increase the chances of meeting someone you share interests with!';
			echo '<a href ="/profile/questions"> Answer Now! </a>';
		}
	}
}