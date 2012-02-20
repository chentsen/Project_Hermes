<?php
//use bootstrap later
//require_once('Documents/User.php');
//require_once('repositories/User.php');
use Facebook\Facebook;
use Documents\Interest;
use Documents\User;
use Documents\Userflow;
class Application_Model_UserSettings{
	private $user;
	private $dm;
	public function __construct($mongoContainer,$user = null){
		$this->dm = $mongoContainer->getDocumentManager('default');
		if($user){
			$this->user = $user;
		}
	}
	
	/*wrapper around Zend_Auth to account for facebook account*/
	
	public static function hasIdentity(){
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			return $auth->getIdentity();
		}else{
			$user_data = self::getFBData();
			if($user_data['user'] && $user_data['user_profile']){
				$user_profile = $user_data['user_profile'];
				$dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
				$pt_user = $dm->getRepository('Documents\User')->findOneBy(array('email'=>$user_profile['email']));
				if($pt_user){
					if($pt_user->getIsFBAccount()){
					   //var_dump($pt_user->getEmail());
					   return $pt_user->getEmail();
					}				
				}
				
		       }
		}
		return false;
	}
	public static function fbNotComplete() {
		$auth = Zend_Auth::getInstance();
		$user_data = self::getFBData();
		if($user_data['user']) {
			
		}
		
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
			
			//default email permissions to true
			$user->setEmailPerm(true);
			$user->setIsFBAccount(false);
			
			//hash the password for security
			$hashedPassword = md5($userInfo['password']);
			$user->setPassword($hashedPassword);
			
			//set a random hash for account confirmation
			$randomHash = md5(uniqid(rand(),true));
			$user->setConfirmation($randomHash);
			$interest = new Interest();
			$user->setInterest($interest);
			$flow = new Userflow();
			$user->setUserflow($flow);
			$this->dm->persist($flow);
			$this->dm->persist($user);
			$this->dm->persist($interest);
			$this->dm->flush();
			return $user->getConfirmation();
		}
		else{
			return false;
		}	
	}
	public function fbRegister($user_profile,$isRetry = false){
		$params = array();
		if(!$this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$user_profile['email']))){
			$user = new User();
			if(!$isRetry){
				//hack to cut the city into two parts
				$city_raw = explode(',',$user_profile['location']['name']);
				$city = $city_raw[0];
				$email = $user_profile['email'];
				$firstName = $user_profile['first_name'];
				$lastName = $user_profile['last_name'];
				$gender_raw = $user_profile['gender'];
				//$setEmailPerm = $user_profile['setEmailPerm'];
				if(!empty($gender_raw)){
					if($gender_raw == 'male'){
						$gender = 'm';
					}else if($gender_raw == 'female'){
						$gender = 'f';
					}else{
						$gender = 'n';
					}
				}
				$betakey = $user_profile['betakey'];
				$params['city'] = $city;
				$params['email'] = $email;
				$params['firstName'] = $firstName;
				$params['lastName'] = $lastName;
				$params['gender'] = $gender;
				$params['betakey'] = $betakey;
				//$params['setEmailPerm'] = $setEmailPerm;
				
				//check to make sure all inputs are valid;
			}else{
				//otherwise, we have tried to validate before and should use what's in the session
				$params = $user_profile;
			}
			foreach($params as $input){
			//if any input is empty, return it so user can be redirected to a new
			//page with additional info to input.
				if(empty($input))
					return $params;
			}
			$user->setEmail($params['email']);
			$user->setFirstName($params['firstName']);
			$user->setLastName($params['lastName']);
			$user->setCity($params['city']);
			$user->setGender($params['gender']);
			$user->setEmailPerm(true);
			$randomHash = md5(uniqid(rand(),true));
			$user->setConfirmation($randomHash);
			//Don't need to confirm for FB logged in users
			//NOTE: What kind of security does FB put behind registration?
			$interest = new Interest();
			$user->setInterest($interest);
			$flow = new Userflow();
			$user->setUserflow($flow);
			$user->setIsFBAccount(true);
			$this->dm->persist($flow);
			$this->dm->persist($user);
			$this->dm->persist($interest);
			$this->dm->flush();
			$this->confirmAccount($randomHash);
			return true;
			
		}else{
			return false;
		}
	}
       public function updateinfo($userInfo){
            
                $this->user->setFirstName($userInfo['firstName']);
                $this->user->setLastName($userInfo['lastName']);
                $this->user->setCity($userInfo['city']);
		$this->user->setGender($userInfo['gender']);
		$this->user->setDescription($userInfo['description']);
		$this->user->setEmailPerm($userInfo['hasEmailPerm']);
		$this->dm->persist($this->user);
		$this->dm->flush();
            
        }
		public function updatePassword($password) {
			$hashedPassword = md5($password['originalPassword']);
			if ($this->user->getPassword() == $hashedPassword &&
					$password['password'] == $password['password2']) {
				$this->user->setPassword(md5($password['password']));
				$this->dm->persist($this->user);
				$this->dm->flush();
				return true;
			}
			return false;
		}
		public function resetPassword() {
			
			$newPassword = substr(md5(time()),0,8);
			//must hash before store into document
			$storePassword = md5($newPassword);
			if($this->user){
				$this->user->setPassword($storePassword);
				$this->dm->persist($this->user);
				$this->dm->flush();
			}
			return $newPassword;
		}
	private function encryptPassword(){
		
	}
	public function confirmAccount($key){
		$foundUser = $this->dm->getRepository('Documents\User')->findOneBy(array('confirmation' => $key));
		if($foundUser){
				$foundUser->setConfirmation("confirmed");
				$this->dm->persist($foundUser);
				$this->dm->flush();
				return true;
		}		
		else{
			return false;
		}
	}
	public function authenticateUser($email,$password){
		//get the correct mongoDB url and also
		$m = new Mongo(Zend_Registry::get('config')->siteInformation->mongoDB);
		// connect
		
		$usersCollection = $m->selectCollection("doctrine","users");
		//echo 'AUTHENTICATING';
		//print_r(iterator_to_array($usersCollection->find()));
		//echo $usersCollection;
		$authAdapter = new Zend_Auth_Adapter_MongoDB($usersCollection, 'email',"password",null);
		$authAdapter->setIdentity($email);
		//echo $email;
		$hashedPassword = MD5($password);
		//echo $hashedPassword;
		//echo $hashedPassword;
		$authAdapter->setCredential($hashedPassword);
		
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
	
		//login the user
		if($result->isValid()){
			
			$this->user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$email));
			//echo $this->user->getEmail();
			if($this->user->getConfirmation() == "confirmed"){
				Zend_Session::rememberMe(1209600);
				return true;
			}else{
				$auth->clearIdentity();
			}	
		}
		else{
			
			//echo 'RESULT WASNT VALID';
			return false;
		}
	}
	/*returns an array of data including the user object and the data object from fb or false if not logged in*/
	public static function getFBData(){
		$appId = Zend_Registry::get('config')->siteInformation->appId;
		$secret = Zend_Registry::get('config')->siteInformation->secret;
		$facebook = new Facebook(array(
		    'appId'=>$appId,
		    'secret'=>$secret
		));
		try{
			$user = $facebook->getUser();
		}catch (FacebookApiException $e){
			
			//echo $e->getTraceAsString();
			//echo $e->getMessage();
			$user = null;
		}
		if ($user) {
		    try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
			return array('user_profile'=>$user_profile,'user'=>$user);
			//var_dump($user_profile);
		    } catch (Exception $e) {
			//echo 'SOMETHING IS WRONG';
			//echo $e->getTraceAsString();
			//echo $e->getMessage();
			$user = null;
		    }
		    
		}
		return false;
	}
	public function hasDescription(){
		if(!$this->user->getDescription()){
			return false;
		}else{
			return true;
		}
	}
	public function setDescription($description){
		$this->user->setDescription($description);
		$this->dm->persist($this->user);
		$this->dm->flush();
	}
}

