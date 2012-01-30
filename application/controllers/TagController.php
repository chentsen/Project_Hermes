<?php
class TagController extends Hermes_Controller_SessionController{
	public function init(){
		parent::init();
	}
	public function indexAction(){
		
	}
	public function addTagAction(){
		//$this->_helper->viewRenderer->setNoRender();
		$tagName = $this->_request->getParam('tag_input');
		$tagModel = new Application_Model_TagModel($this->curUser);
		if(!strpos($tagName,'"') || !strpos($tagName,'\'') || !empty($tagName))
			$tagModel->addTag($tagName,false);
	}
	public function addTagAjaxAction(){
		$this->_helper->viewRenderer->setNoRender();
		 $this->_helper->layout()->disableLayout();
		$tagNames = $this->_request->getParam('tags');
		$tagModel = new Application_Model_TagModel($this->curUser);
		if(!$tagModel)
			break;
		if($tagModel->addTagList($tagNames)){
			echo $this->refreshTag($tagModel);
		}
	}
	private function refreshTag($tagModel){
		$interestModel = $tagModel->interestModel;
			$returnTags = $interestModel->getTags();
			$jsonArray = array();
			if($returnTags){
				$states = $interestModel->interest->getState();	
				foreach($returnTags as $tag){
					if($tag == '')
						continue;
					
					$subArray['tagName'] = ($tag->getTagName());
					$subArray['enabled'] = ($states[$tag->getTagName()]);	
					$jsonArray[]=$subArray;
					
				}	
			}
			return json_encode($jsonArray);
	}
	public function deleteTagAction(){
		$this->_helper->viewRenderer->setNoRender();
		 $this->_helper->layout()->disableLayout();
		 $tagName = $this->_request->getParam('tag');
		$tagModel = new Application_Model_TagModel($this->curUser);
		if(!$tagModel)
			break;
		$tagModel->deleteTag($tagName);
		
		 
	}
	public function toggleTagAction(){
		$this->_helper->viewRenderer->setNoRender();
		 $this->_helper->layout()->disableLayout();
		 $tagName = $this->_request->getParam('tag');
		 $interestModel = new Application_Model_InterestModel($this->curUser->getInterest());
		 $interestModel->toggleTag($tagName);	
	
	}
	public function getDisplayAction(){
		 $this->_helper->viewRenderer->setNoRender();
		 $this->_helper->layout()->disableLayout();
		 $tagModel = new Application_Model_TagModel();
		 $tagModel->setRankedTags(2);
		 $rankedTags = $tagModel->getRankedTags();
		 $jsonArray = array();
		 if($rankedTags){
			 foreach($rankedTags as $tag){
			 	$subArray['value']=$tag->getTagName();
			 	$subArray['name']=$tag->getTagName();
			 	$jsonArray[] = $subArray; 
			 }
		 }else{
		 	$jsonArray = "";
		 }
		 echo json_encode($jsonArray);
		 //returns a JSON delimited series of tags to show
	}
}