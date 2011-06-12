<?php
namespace Documents;
/** @Document(collection="users", repositoryClass="Repositories\User") */
class User{
	//EMAIL, ALTHOUGH UNIQUE, SHOULD NOT BE USED AS PRIMARY KEY, FOR INDEXING SECURITY REASONS
	/** @Id*
	 *  
	 */
	private $uid;
	
	/** @Field(type="string")*/
	private $email;
	
	/** @Field(type="string")*/
	private $firstName;
	
	/** @Field(type="string")*/
	private $lastName;
	
	/** @Field(type="string")*/
	private $gender;
	
	/** @Field(type="string")*/
	private $city;
	
	/** @Field(type="string")*/
	private $password;
	
	/** @Field(type="string")*/
	private $confirmation;
	
	/**
     * @ReferenceMany(targetDocument="User", mappedBy="friends")
     */
    public $friendsWithUser;
	
     /**
     * @ReferenceMany(targetDocument="User", inversedBy="friendsWithUser")
     */
    public $friends;
	public function __construct()
    {
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
				
}