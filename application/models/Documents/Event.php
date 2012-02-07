<?php
namespace Documents;
/** @Document(collection="event", repositoryClass="Repositories\Event")*/
class Event{
 /** @Id(strategy="NONE") */
	private $eid;
	
	//string
	/** @Field(type="string")*/
	private $location;
	
	//date 
	/** @Date*/
	private $date;
	
	//textblob
	/** @Field(type="string")*/
	private $shortDescription;
	
	//textblob
	/** @Field(type="string")*/
	private $longDescription;
	
	//boolean
	/** @Field(type="boolean")*/
	private $isPrivate;
	
	//list of users
	/** @ReferenceMany(targetDocument="User")*/
	private $members;
	
	//list of users
	/** @ReferenceMany(targetDocument="User")*/
	private $interestedUsers;
	
	//user	
	/** @ReferenceOne(targetDocument="User")*/
	private $creator;
	
	/** @ReferenceOne(targetDocument="Wall")*/
	private $wall;
	
	//list of users
	/** @ReferenceMany(targetDocument="User")*/
	private $waitingList;
	
	/** @Date*/
	private $timestamp;
	/**
     * 
     * @ReferenceOne(targetDocument="Image")
     * 
     */
    private $eventPic;
	
	
	public function __construct($options){
		$this->location = $options['location'];
		$this->date = $options['date'];
		$this->shortDescription = $options['shortDescription'];
		$this->longDescription = $options['longDescription'];
		$this->isPrivate = $options['private'];
		$this->members = array($options['creator']);
		//echo $options['creator']->getEmail();
		//echo $this->members[0]->getEmail();
		$this->creator = $options['creator'];
		$this->timestamp = new \DateTime("now");
		$this->eid = $options['id'];
		$this->wall = new Wall($this);
	}
	
	public function getCreator(){
		return $this->creator;
	}
	public function getLocation(){
		return $this->location;
	}
	public function isPrivate(){
		return $this->private;
	}
	public function getShortDescription(){
		return $this->shortDescription;
	}
	public function getLongDescription(){
		return $this->longDescription;
	}
	public function getMembers(){
		return $this->members;
	}
	public function getDate(){
		return $this->date;
	}
	public function addWaitingList($user){
		$this->waitingList[] = $user;
	}
	public function getWaitingList(){
		return $this->waitingList;
	}
	public function addMember($user){
		$this->members[] = $user;
	}
	
	public function removeWaitingList($user){
		for($i = 0; $i < count($this->members); ++$i){
			
			//terrible code. to fix 
			//if waiting
				//echo $this->waitingList;
				if($this->waitingList[$i]->getEmail() == $user->getEmail()){
					unset($this->waitingList[$i]);
					//this may be an issue
					if($i>0)
						$this->waitingList = array_values($this->waitingList);
					else return;
				}
			
		}
	}
	public function getEid(){
		return $this->eid;
	}
	public function getWall(){
		return $this->wall;
	}
	public function getEventPic(){
    	return $this->eventPic;
    }
    public function setEventPic(Image $image){
    	$this->eventPic = $image;
    }
}