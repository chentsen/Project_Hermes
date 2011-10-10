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
			$interestModel = $tagModel->interestModel;
			$returnTags = $interestModel->getTags();
			$jsonArray = array();
			if($returnTags){
				foreach($returnTags as $tag){
					if($tag == '')
						continue;
					$jsonArray[]=$tag->getTagName();
					
				}	
			}
			echo json_encode($jsonArray);
		}
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