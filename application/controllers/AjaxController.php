<?php
class AjaxController extends Zend_Controller_Action{
	 public function init(){
	 	
	 }
	 public function indexAction(){
		$this->_helper->viewRenderer->setNoRender();	 
	 }
	 public function loadFeedAction(){
	 	$this->_helper->layout()->disableLayout();
	 	$identity = $this->_request->getParam("identity");
	 	$this->view->identity = $identity;
	 }
}