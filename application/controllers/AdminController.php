<?php
class AdminController extends Zend_Controller_Action{
	public function init(){
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$this->identity = $this->_helper->GetIdentity->GetIdentity();
        $this->curUser = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$this->identity));
	}
	public function indexAction(){
		$this->_helper->viewRenderer->setNoRender();
	}
	public function generateKeysAction(){
		$this->_helper->viewRenderer->setNoRender();
	
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
	public function generateInitKeyAction(){
		$this->_helper->viewRenderer->setNoRender();
		//once we are online, initialize as development
		if(getenv('APPLICATION_ENV') == "development"){
				$betakey = new Documents\Betakey();
				$this->dm->persist($betakey);
				$this->dm->flush();
				echo 'Beta Key:'.$betakey->getKey().' can be used to register..';
		}
	
	}
}