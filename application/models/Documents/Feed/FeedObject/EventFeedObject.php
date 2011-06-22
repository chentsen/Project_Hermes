<?php 
namespace Documents\Feed\FeedObject;
/** @EmbeddedDocument*/
class EventFeedObject extends FeedObject{
	/** @String */
	private $shortDescription;
	/** @String */
	private $eid;
	/** @ReferenceOne(targetDocument="Documents\User") */
	private $creator;
	
	public function __construct($shortDescription,$eid,$date,$creator){
		
		$this->shortDescription = $shortDescription;
		$this->eid = $eid;
		$this->date = $date;
		$this->creator = $creator;
	}
	public function getCreator(){
		return $this->creator;
	}
	public function getShortDescription(){
		return $this->shortDescription;
	}
}

//on acceptance to the event, send off notice to feed model to create a feed object
//on deletion of user or event send off notice to feed model to search for object with eid and delete if it exists