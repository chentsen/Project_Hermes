<?php
//use bootstrap later
require_once('documents/User.php');
require_once('repositories/User.php');
use Documents\User;
class Application_Model_UserSettings{
	private $user;
	private $dm;
	public function __construct($mongoContainer){
		$this->dm = $mongoContainer->getDocumentManager('default');
	}
	
	
	//returns boolean if fails, otherwise returns the activation code
	public function register($userInfo){
		//if email doesnt exist then serialize and return true
		
		if(!$this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$userInfo['email']))){
			$user = new User();
			$user->setEmail($userInfo['email']);
			$user->setFirstName($userInfo['firstName']);
			$user->setLastName($userInfo['lastName']);
			$user->setGender($userInfo['gender']);
			$user->setCity($userInfo['city']);
			
			//hash the password for security
			$hashedPassword = md5($userInfo['password']);
			$user->setPassword($hashedPassword);
			
			//set a random hash for account confirmation
			$randomHash = md5(uniqid(rand(),true));
			$user->setConfirmation($randomHash);
			$this->dm->persist($user);
			$this->dm->flush();
			return $user->getConfirmation();
		}
		else{
			return false;
		}	
	}
	private function encryptPassword(){
		
	}
	public function confirmAccount($key){
		$foundUser = $this->dm->getRepository('Documents\User')->findOneBy(array('confirmation' => $key));
		if($foundUser){
				$foundUser->setConfirmation(null);
				$this->dm->persist($foundUser);
				$this->dm->flush();
				return true;
		}		
		else{
			return false;
		}
	}
}

