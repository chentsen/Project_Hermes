<?php 
namespace Documents;

/** @Document(collection="tags, repositoryClass="Repositories\Tag)*/
class Tag{
	/** @Id
	 * 
	 */
	private $tagID;
	
	/**
	 * @Field(type="string")
	 */
	private $tagName;
	
	/**
	 * @Field(type="int")
	 */
	private $count;
	
	/**
	 * @Field(type="boolean")
	 */
	private $isCurated;
	
	private $count;
	
	public function __construct($options){
		if($option['tagName']){
			$this->tagName = $option['tagName'];
		}
		if($option['isCurated']){
			$this->isCurated = true;
		}else{
			$this->isCurated = false;
		}
		$this->count = 1;
	}
	
	public function getTagName(){
		return $this->tagName;
	}
	public function setTagName($tagName){
		return $this->tagName;
	}
	public function incrementCount(){
		$this->count++;
	}
	public function decrementCount(){
		$this->count--;
	}
	public function getCount(){
		return $this->count;
	}
}

?>