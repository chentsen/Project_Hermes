<?php
namespace Documents;
/** @Document(collection="users", repositoryClass="Repositories\User") */
class User{
	//EMAIL, ALTHOUGH UNIQUE, SHOULD NOT BE USED AS PRIMARY KEY, FOR INDEXING SECURITY REASONS
	/** @Id(strategy = "NONE")*
	 *  
	 */
	private $uid;
	
	/** @Field(type="string")*/
	private $email;
	
	/** @Field(type="string")*/
	private $firstName;
	
	/** @Field(type="boolean")*/
	private $isFBAccount;
	
	/** @Field(type="boolean")*/
	private $hasEmailPerm;
	
	/** @Field(type="string")*/
	private $lastName;
	
	/** @Field(type="string")*/
	private $gender;
	
	/** @Field(type="string")*/
	private $city;
	
	/** @Field(type="string")*/
	private $description;
	
	/** @Field(type="string")*/
	private $password;
	
	/** @Field(type="string")*/
	private $confirmation;
	/** @ReferenceMany(targetDocument="Event")
	 * 
	 */
	private $events;
	
	/** @ReferenceOne(targetDocument="Documents\Feed\EventFeed", inversedBy = "user")
	 * 
	 */
	private $eventFeed = null;
	/** @ReferenceOne(targetDocument="Documents\Feed\GeneralFeed", inversedBy = "user")
	 * 
	 */
	private $generalFeed = null;
	
	/**
     * @ReferenceMany(targetDocument="User", mappedBy="friends")
     */
    public $friendsWithUser;
	
     /**
     * @ReferenceMany(targetDocument="User", inversedBy="friendsWithUser")
     */
    public $friends;
    
    /**
     *@ReferenceOne(targetDocument="Userflow") 
     */
    public $userflow;
    
    /**
     * 
     * @ReferenceOne(targetDocument="Interest")
     * 
     */
    private $interest;
    
    /**
     * 
     * @ReferenceOne(targetDocument="Image")
     * 
     */
    private $profilePic;
	public function __construct()
    {
        
    	$this->uid = uniqid(rand(),false);
    	$this->friendsWithUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Friends = new \Doctrine\Common\Collections\ArrayCollection();
    }
	/**
	 * 
	 * function to add friend to the user, must be called for both friends.
	 * @param User $user
	 */
    public function addFriend(User $user)
    {
        $user->friendsWithUser[] = $this;
        $this->friends[] = $user;
    }
	
	public function setEmail($email){
		$this->email = $email;
	}
	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}
	public function setLastName($lastName){
		$this->lastName = $lastName;
	}
	public function setGender($gender){
		$this->gender = $gender;
	}
	public function setCity($city){
		$this->city = $city;
	}
	public function setPassword($hashedPassword){
		$this->password = $hashedPassword;
	}
	public function setConfirmation($randomHash){
		$this->confirmation = $randomHash;
	}
	public function getConfirmation(){
		return $this->confirmation;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getFriends(){
		return $this->friends;
	}
	public function getFirstName(){
		return $this->firstName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function getEvents(){
		return $this->events;
	}
	public function addEvent(Event $event){
		$this->events[] = $event;
	}
	public function removeEvent(Event $event){
		
	}
	public function getEventFeed(){
		return $this->eventFeed;
	}
	public function setEventFeed($eventFeed){
		$this->eventFeed = $eventFeed;
	}
	public function setGeneralFeed($generalFeed){
		$this->generalFeed = $generalFeed;
	}
	public function getGeneralFeed(){
	 return	$this->generalFeed;
	}
	public function getUid(){
		return $this->uid;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($description){
		$this->description = $description;
	}
	public function setInterest(Interest $interest){
		$this->interest = $interest;
	}
	public function getInterest(){
		return $this->interest;
	}
    public function getCity(){
        return $this->city;
    }
    public function getUserflow(){
    	if($this->userflow){
    		return $this->userflow;
    	}else{
    		$this->userflow = new Userflow();
    	} 	
    }
    public function setUserflow(Userflow $userflow){
    	$this->userflow = $userflow;
    }
    public function getProfilePic(){
    	return $this->profilePic;
    }
    public function setProfilePic(Image $image){
    	$this->profilePic = $image;
    }
    public function getGender(){
	return $this->gender;
    }
    public function setIsFBAccount($bool){
	$this->isFBAccount = $bool;
    }
    public function getIsFBAccount(){
	return $this->isFBAccount;
    }
	public function hasEmailPerm(){
		if($this->hasEmailPerm === null){
			$this->hasEmailPerm = true;
		}
		return $this->hasEmailPerm;
	}
	public function setEmailPerm($perm){
		$this->hasEmailPerm = $perm;
	}
}