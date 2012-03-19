<?php

class AccountEditController extends Hermes_Controller_SessionController
{

    public function init()
    {
        if($this->_helper->FlashMessenger->hasMessages()){
			$this->view->flashMessages = $this->_helper->FlashMessenger->getMessages();
	}
        parent::init();
     
        $this->view->identity = $this->identity;
                $this->firstname = $this->curUser->getFirstName();
                $this->lastname = $this->curUser->getLastName(); 
                $this->city = $this->curUser->getCity();
                $this->description = $this->curUser->getDescription();
                $this->gender = $this->curUser->getGender();
                $this->hasEmailPerm = $this->curUser->hasEmailPerm();
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
        $this->view->gender = $this->gender;
        $this->view->hasEmailPerm = $this->hasEmailPerm;
	$this->view->curUser =$this->curUser;
        
        $options = array('firstName'=>$this->firstname, 'lastName'=>$this->lastname, 'gender'=>$this->gender,'city'=>$this->city,'description'=>$this->description, 'hasEmailPerm'=>$this->hasEmailPerm);
        
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
		    $filePath = $_FILES['image']['tmp_name'];
		    $pathInfo = pathinfo($filePath);
		   // echo $filePath;
		    
		    //print_r($pathInfo);
		    $type = explode('/',$_FILES['image']['type']);
		    //$extension = str_replace('/','',$_FILES['image']['type']);
		    $image_name = 'profile_pic_'.$this->curUser->getUid().'.jpeg';
		    //echo $image_name;
		    $this->_helper->flashMessenger->addMessage("Image uploaded! It may take some time to update.");
		    Application_Model_ImageModel::scaleImage($filePath,300,300,'/image/profile/'.$image_name,$type[1]);
		    $this->_redirect('/account-edit');
		    
		    //return image path
		    //return json_encode(array('path'=>Application_Model_Utils_ImageUtil::getProfilePicURL($this->curUser)));
		    /*
	    		$imageModel = new Application_Model_ImageModel($this->curUser);
			
	    		$imageModel->makeProfilePicture($_FILES['image']['tmp_name'],$_FILES['image']['type']);
	    		$this->_redirect('/account-edit');*/
	    		//echo 'image saved!';
    		}
    	}else{
    		$this->_redirect('/account-edit');
    	}
    	
    }

}

