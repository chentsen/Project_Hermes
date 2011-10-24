<?php
class Zend_View_Helper_DisplayNewUserflow extends Zend_View_Helper_Abstract{
	public function DisplayNewUserflow($status){
		if($status == 0){

			echo '<div class="questions_flow">Want to increase your chance of finding cool people? Fill in some common tagss';
			echo ' <a href ="#" onclick = "Questions.showQuestions()">here</a>.</div>';
		}
		else if($status < 4 && $status > 0){
			echo '<div class="questions_flow">Want to increase your chance of finding cool people? Fill in some common tags';
			echo ' <a href ="#" onclick="Questions.showQuestions()">here</a>.</div>';
		}
	}
}