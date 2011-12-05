<?php
namespace Documents\Feed\FeedObject;

/** @EmbeddedDocument */
class FriendEventFeedObject extends FeedObject{
	/** @String */
	private $eid;
	
	/** @String */
	private $shortDescription;
	
}