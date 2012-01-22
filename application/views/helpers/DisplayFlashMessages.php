<?php
class Zend_View_Helper_DisplayFlashMessages extends Zend_View_Helper_Abstract{
	public function DisplayFlashMessages($FlashMessages){
					echo "<div id ='flashMessages'>";	
			echo "<ul>";
		if($FlashMessages){

			foreach($FlashMessages AS $FlashMessage){
				echo "<li>{$FlashMessage}<div class='exitBox'";
                                echo 'onclick="Display.hideDisplay(\'#flashMessages\')"></div></li>';
			}
			
		}
		echo "</ul>";
			echo "</div>";
	}
}