<?php
namespace Documents;
/** @Document(collection="interests", repositoryClass="Repositories\Interest") */
class Interest{
	/** @Id
	 * 
	 */
	private $id;
	/** @ReferenceMany(targetDocument="Tag")*/
	private $tags; 
	/** @Field(type="hash")*/
	public $state;
	
	public function __construct(){	
	}
	public function getTags(){
	    return $this->tags;
	}
	public function getActivatedTags(){
		$activatedTags = array();
		foreach($this->tags as $tag){
			if($this->state[$tag->getName()]){
				$activatedTags[] = $tag;
			}
		}
	}
	public function setTags($tags){
		$this->tags = $tags;
	}
	public function addUserTag(Tag $tag){
		$this->tags[] = $tag;
		//initalize the state as activated;
		$this->state[$tag->getTagName()] = true;
	}
	public function deleteTag(Tag $tag){
		
	}
	public function disableState($tagName){
		$this->state[$tagName] = false;	
	}
	public function activateState($tagName){
		$this->state[$tagName] = true;	
	}
	public function getState(){
		return ($this->state);
	}
}