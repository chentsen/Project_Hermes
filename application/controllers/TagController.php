<?php
class TagController extends Hermes_Controller_SessionController{
	public function init(){
		parent::init();
	}
	public function indexAction(){
		
	}
	public function addTagAction(){
		$tagName = $this->_request->getParam('tag_input');
		$tagModel = new TagModel($this->curUser);
		$tagModel->addTag($tagName,false);
	}
}