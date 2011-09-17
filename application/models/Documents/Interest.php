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
	public function __construct(){
	   $this->tags = new \Doctrine\Common\Collections\ArrayCollection();	
	}
	public function getTags(){
		return $this->tags;
	}
	public function setTags($tags){
		$this->tags = $tags;
	}
	public function addUserTag(Tag $tag){
		$this->tags[] = $tag;
	}
	public function deleteTag(Tag $tag){
		
	}
}