<?php
//use bootstrap later
//require_once('Documents/User.php');
//require_once('repositories/User.php');
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
       public function updateinfo($userInfo){
            
                $this->user->setFirstName($userInfo['firstName']);
                $this->user->setLastName($userInfo['lastName']);
                $this->user->setCity($userInfo['city']);
		$this->dm->persist($this->user);
		$this->dm->flush();
            
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

