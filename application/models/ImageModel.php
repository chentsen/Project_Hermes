<?php
class Application_Model_ImageModel extends Application_Model_BaseModel{
	private $user;
	public function __construct($user){
		parent::__construct();
		$this->user = $user;
	}
	public function makeProfilePicture($image,$type){
		$imageNamge = $this->user->getUid()."_profile_pic";
		$profilePic = new Documents\Image($image,$imageName,$type);
		$this->user->setProfilePic($profilePic);
		$this->dm->persist($profilePic);
		$this->dm->persist($this->user);
		$this->dm->flush();				
	}
	public function deleteProfilePicture(){
		$this->user->setProfilePic(null);
	}
	public function getProfilePicture(){
		if($this->user->getProfilePic == null){
			//return some generic photo
		}else{
			return $this->user->getProfilePic();
		}
	}
	

}