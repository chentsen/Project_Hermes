<?php
class Application_Model_Utils_ImageUtil{
	//reindex
	public static function getProfilePicURL(&$user){
            $pathRoot = Zend_Registry::get('config')->siteInformation->static_path;
       
			$picRoot = '/image/profile/';
            $picName = 'profile_pic_'.$user->getUid();
            $fullRoot = $pathRoot.$picRoot.$picName.'.jpeg';
            if(is_readable($fullRoot)){
                return $picRoot.$picName.'.jpeg';
            }else{
                return '/images/placeholder.png';
            }
        }
}
?>