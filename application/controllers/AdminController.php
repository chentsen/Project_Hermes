<?php
class AdminController extends Hermes_Controller_SessionController{
	public function indexAction(){
		$this->_helper->viewRenderer->setNoRender();
	}
	public function generateKeysAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		if($this->curUser->getEmail() == "chentsen3@gmail.com"){
			for($i=0;$i<1000;$i++){
				$betakey = new Documents\Betakey();
				$this->dm->persist($betakey);
				
			}
			$this->dm->flush();
			echo 'Keys generated successfully';
		}
	}
	//generate First keys -- check for application ini status..if staging, then generate key (for use for us to register)
	public function generateInitKeysAction(){
		$this->_helper->viewRenderer->setNoRender();
		
	}
}