<?php
namespace Documents\Feed;
/** @Document(collection="generalFeed", repositoryClass="Repositories\Feed\GeneralFeed") */
class GeneralFeed extends Feed{
	/** @Id*/
	protected $feed_id;
	/** @EmbedMany*/
	protected $feedObject = array();
}