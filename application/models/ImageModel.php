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
	public static function scaleImage($source, $max_width, $max_height, $destination,$ext) {
		$destinationRoot = Zend_Registry::get('config')->siteInformation->static_path;
		$destination = $destinationRoot.$destination;
		list($width, $height) = getimagesize($source);
		if ($width > 150 || $height > 150) {
		    $ratioh = $max_height / $height;
		    $ratiow = $max_width / $width;
		    $ratio = min($ratioh, $ratiow);
		    // New dimensions
		    $newwidth = intval($ratio * $width);
		    $newheight = intval($ratio * $height);
	    
		    $newImage = imagecreatetruecolor($newwidth, $newheight);
	    
		    $exts = array("gif", "jpg", "jpeg", "png");
		    $pathInfo = pathinfo($source);
			
		
		    $sourceImage = null;
	    
		    // Generate source image depending on file type
		    switch ($ext) {
			case "jpg":
			case "jpeg":
			    $sourceImage = imagecreatefromjpeg($source);
			    break;
			case "gif":
			    $sourceImage = imagecreatefromgif($source);
			    break;
			case "png":
			    $sourceImage = imagecreatefrompng($source);
			    break;
		    }
			
		    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	    
		    // Output file depending on type
		
		
		imagejpeg($newImage, $destination);
			
		
		}
	}

}