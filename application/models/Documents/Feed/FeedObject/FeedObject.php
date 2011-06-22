<?php
namespace Documents\Feed\FeedObject;

/**@MappedSuperclass*/
abstract class FeedObject{
	/** @Id */
	protected $fid;
	/** @Date */
	protected $date;
	/** @Boolean */
	protected $hidden = false;
	public function getFid(){
		return $this->fid;
	}
	public function getDate(){
		return $this->date;
	}
	public function getHidden(){
		return $this->hidden;
	}                   


}