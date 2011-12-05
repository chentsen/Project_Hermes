<?php
namespace Documents;

/** @Document(collection="images") */
class Image{
	/** @Id */
	private $id;
	
	/** @String */
	private $name;
	
	/** @String */
	private $contentType;
	
	/** @File */
	private $pic;
	
	public function __construct($file,$name,$type){
		$this->pic = $file;
		echo 'setting file as '.$file;
		$this->name = $name;
		$this->contentType = $type;
		echo '<br> type is '.$type;
	}
	public function getPic(){
		return $this->pic;
	}
	public function setPic($pic){
		$this->pic = $pic;
	}
	public function getType(){
		return $this->contentType;
	}
	
	
}