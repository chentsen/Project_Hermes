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
    public function ajaxformAction()
	{
		 $this->_helper->viewRenderer->setNoRender();
                  $this->_helper->getHelper('layout')->disableLayout();
				  $form = new Application_Form_Registration();
				   $form->isValid($this->_getAllParams());
				  $json = $form->getMessages();
				  header('Content-type: application/json');
				  echo Zend_Json::encode($json);
		
	}
	public function ajaxloginAction()
	{
				  
		$this->_helper->viewRenderer->setNoRender();
                $this->_helper->getHelper('layout')->disableLayout();
                
                //pull content json
                $form = new Application_Form_Login();
                $form->isValid($this->_getAllParams());
				  $json = $form->getMessages();
				 
		header('Content-type: application/json');
		echo Zend_Json::encode($json);
	}
}