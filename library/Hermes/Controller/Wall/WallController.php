<?php
abstract class Hermes_Controller_Wall_WallController extends Hermes_Controller_SessionController{
	public function init(){
		parent::init();
		  $this->mongoContainer = Zend_Registry::get('Wildkat\DoctrineContainer');
		$this->dm = $this->mongoContainer->getDocumentManager('default');
	}
	public function deleteAction(){
		$this->_helper->ViewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		$eid = $this->_request->getParam("eid");
		$pid = $this->_request->getParam("postid");
		$wall = $this->dm->getRepository('Documents\Wall')->findOneBy(array('event.$id'=>$eid));
		$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$this->identity));
		$wallModel = new Application_Model_WallModel($wall);
		$wallModel->deletePost($pid,$user);
		
		
	}	
	public function addAction(){
		$this->_helper->ViewRenderer->setNoRender(true);
		$eid = $this->_request->getParam("eid");
		$wall = $this->dm->getRepository('Documents\Wall')->findOneBy(array('event.$id'=>$eid));
		$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$this->identity));
	        $wallModel = new Application_Model_WallModel($wall);      
		$comment = $this->getRequest()->getPost('wall_comment');
	        $wallModel->addPost($user, $comment);
	}
	public function ajaxWallRefreshAction(){
		$this->_helper->ViewRenderer->setNoRender(true);
		$eid = $this->_request->getParam("eid");
		$wall = $this->dm->getRepository('Documents\Wall')->findOneBy(array('event.$id'=>$eid));
		$this->_helper->layout()->disableLayout();
		$wallPosts = array();
		foreach($wall->getWallPosts() as $wallPost){
			$poster = $wallPost->getUser(); 
			$wallPostA['firstName'] = $poster->getFirstName();
			$wallPostA['message'] = $wallPost->getMessage();
			$wallPostA['postID'] = $wallPost->getPostID();
			$wallPostA['uid'] = $poster->getUid();
			$wallPostA['imgSrc'] = Application_Model_Utils_ImageUtil::getProfilePicURL($poster);
			if($poster->getEmail() == $this->curUser->getEmail())
				$wallPostA['isPoster'] = true;
			else
				$wallPostA['isPoster'] = false;
			$wallPosts[] = $wallPostA;
		}
		echo json_encode($wallPosts);
	}
}