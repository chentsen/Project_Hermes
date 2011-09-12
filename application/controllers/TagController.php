<?php
class TagController extends Hermes_Controller_SessionController{
	public function init(){
		parent::init();
	}
	public function indexAction(){
		
	}
	public function addTagAction(){
		$tagName = $this->_request->getParam('tag_input');
		$tagModel = new Application_Model_Tag_Model($this->curUser);
		$tagModel->addTag($tagName,false);
	}
}