<?php
class Application_Model_ImageModel extends Application_Model_BaseModel{
	private $user;
	public function __construct($user){
		parent::__construct();
		$this->user = $user;
	}
	public function makeProfilePicture($image,$type){
		
		$imageName = $this->user->getUid()."_profile_pic";
		$profilePic = new Documents\Image($image,$imageName,$type);
		$this->user->setProfilePic($profilePic);
		$this->dm->persist($profilePic);
		$this->dm->persist($this->user);
		$this->dm->flush();				
	}
	public function deleteProfilePicture(){
		$this->user->setProfilePic(null);
	}
	public function getProfilePicture($user,$response){
			if($this->user->getProfilePic() == null){
				return null;
			}else{
				$type = 'Content-type: '. $user->getProfilePic()->getType().';';
				//echo $type;
				//header($type);
				$response->setHeader('Content-Type', $user->getProfilePic()->getType(), true);
				$response->setHeader('Content-Length', $user->getProfilePic()->getPic()->getSize(), true);
				$response->setBody($user->getProfilePic()->getPic()->getBytes());
				$response->sendResponse();
				die();
			}
	}
	

}