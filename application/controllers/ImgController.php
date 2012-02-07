<?php
class ImgController extends Hermes_Controller_SessionController{
	public function indexAction(){
		$this->_helper->viewRenderer->setNoRender();
	}
	public function profilePicAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		//echo "hello!";
		$uid = $this->_request->getParam('uid');
		if($uid){
			$dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
			$user = $dm->getRepository('Documents\User')->findOneBy(array('uid'=>$uid));
			//invalid user..do nothing
			if(!$user){
				die();
			}else{
				$picModel = new Application_Model_ImageModel($user);
				if($response = $picModel->getProfilePicture($user,$this->_response)){
					$this->_response = $response;
					$this->_response->sendResponse();
				}
				else{
					$this->_redirect('/images/placeholder.png');
				}	
			}
		}
		
		//echo $this->curUser->getProfilePic()->getPic()->getSize();
		//echo ;
	}
}