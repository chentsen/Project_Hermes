<?php
/**
 * 
 * Generates email message based on a layout and data which is passed in
 * @author chentsen
 *
 */
class Zend_Controller_Action_Helper_GenerateEmail extends Zend_Controller_Action_Helper_Abstract{
	function GenerateEmail($layoutFile,array $inputArray){
		
		$view = new Zend_View();
		$view->setScriptPath(APPLICATION_PATH.'/views/scripts/email/'); 
		$view->inputs = $inputArray;
		return $view->render($layoutFile);
	}
}