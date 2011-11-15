<?php

class AccountEditController extends Hermes_Controller_SessionController
{

    public function init()
    {
        
        parent::init();
     

		$this->view->identity = $this->identity;
                $this->firstname = $this->curUser->getFirstName();
                $this->lastname = $this->curUser->getLastName(); 
                $this->city = $this->curUser->getCity();
                $this->description = $this->curUser->getDescription();
                /* Initialize action controller here */
                $bootstrap = $this->getInvokeArg('bootstrap');
		$this->mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
        /* Initialize action controller here */
        $this->view->pageTitle = "Edit Your Account";
        

    }

    public function indexAction()
    {
        // action body
        $this->view->firstname = $this->firstname;
        $this->view->lastname = $this->lastname;
        $this->view->city = $this->city;
        
        
        $options = array('firstName'=>$this->firstname,'lastName'=>$this->lastname, 'city'=>$this->city,'description'=>$this->description);
        $form = new Application_Form_EditAccount($options);
        $profilePic_form = new Application_Form_ProfilePic();
        $this->view->form = $form;
        $this->view->profilePic_form = $profilePic_form;
        
      
        
    }
    public function updateaccountAction() 
    {
        $this->_helper->viewRenderer->setNoRender();
    	$userSettings = new Application_Model_UserSettings($this->mongoContainer,$this->curUser);
    	$userInfo = $userSettings->updateinfo($this->_request->getPost());
        
    	$this->_redirect('/account-edit');
    }
    public function uploadPicAction(){
    	//ajaxify this shit in the future
    	$form = new Application_Form_ProfilePic();
    	 $this->_helper->viewRenderer->setNoRender();
    	//var_dump($_FILES);
    	if($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())){
    		if($form->image->isUploaded()){
	    		$imageModel = new Application_Model_ImageModel($this->curUser);
	    		$imageModel->makeProfilePicture($_FILES['image']['tmp_name'],$_FILES['image']['type']);
	    		$this->_redirect('/account-edit');
	    		//echo 'image saved!';
    		}
    	}else{
    		$this->_redirect('account-edit');
    	}
    	
    }

}

