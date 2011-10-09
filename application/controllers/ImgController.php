<?php
class ImgController extends Hermes_Controller_SessionController{
	public function indexAction(){
		$this->_helper->viewRenderer->setNoRender();
	}
	public function profilePicAction(){
		 $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		//echo "hello!";
		$type = 'Content-type: '. $this->curUser->getProfilePic()->getType().';';
		//echo $type;
		//header($type);
		$this->_response->setHeader('Content-Type', $this->curUser->getProfilePic()->getType(), true);
		$this->_response->setHeader('Content-Length', $this->curUser->getProfilePic()->getPic()->getSize(), true);
		$this->_response->setBody($this->curUser->getProfilePic()->getPic()->getBytes());
		$this->_response->sendResponse();
		die();
		//echo $this->curUser->getProfilePic()->getPic()->getSize();
		//echo ;
	}
}