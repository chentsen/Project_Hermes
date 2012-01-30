<?php 
namespace Documents;

/** @Document(collection="tags", repositoryClass="Repositories\Tag")*/
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
	
	
	public function __construct($options){
		
		$this->tagName = $options['tagName'];
		if($options['isCurated']){
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