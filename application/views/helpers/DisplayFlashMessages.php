<?php
class Zend_View_Helper_DisplayFlashMessages extends Zend_View_Helper_Abstract{
	public function DisplayFlashMessages($FlashMessages){
		if($FlashMessages){
			echo "<div id ='flashMessages'>";	
			echo "<ul>";
			foreach($FlashMessages AS $FlashMessage){
				echo "<li>{$FlashMessage}</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}
}