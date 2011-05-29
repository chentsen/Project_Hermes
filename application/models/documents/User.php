<?php
namespace Documents;
/** @Document(collection="users", repositoryClass="Repositories\User") */
class User{
	
	/** @Id(strategy="NONE",type="string") */
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
	
				
}