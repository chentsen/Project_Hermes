<?php
namespace Documents;
//use \DateTime;

/** @Document(collection="friendRequest", repositoryClass="Repositories\FriendRequest") */
class FriendRequest{
	/** @Id*
	 *  
	 */
	private $requestId;
	
	/** @ReferenceOne(targetDocument = "User") */
	private $requester;
	
	/** @ReferenceOne(targetDocument = "User")*/
	private $requestee;
	
	/** @Date
	 * 
	 */
	private $timestamp;
	
	//constructs a new friend request
	public function __construct($requester, $requestee){
		//$stuff = md5("garbogaskdfasd");
		//echo $stuff;
		$this->timestamp = new \DateTime("now");
		//echo  $this->timestamp->format('Y-m-d H:i:s');
		 $this->requester = $requester;
		 $this->requestee = $requestee;
	}
	public function getRequester(){
		return $this->requester;
	}
	public function getRequestee(){
		return $this->requestee;
	}
	public function getRequestId(){
		return $this->requestId;
	}
}