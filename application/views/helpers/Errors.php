<?php
class Zend_View_Helper_Errors extends Zend_View_Helper_Abstract{
	public function Errors($errorsField){
		if(count($errorsField) > 0){
			echo "<div id = 'errors'>";
			echo "<ul>";
			foreach($errorsField AS $errors){
				foreach($errors AS $error){
					if($error[0] != ""){
						printf("<li>%s</li>", $error);
					}
				}
			}
			echo "</ul>";
			echo "</div>";
		}
	
	}
}