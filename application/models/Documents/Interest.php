<?php
namespace Documents;
/** @Document(collection="interests", repositoryClass="Repositories\Interest") */
class Interest{
	/** @Id()
	 * 
	 */
	private $id;
	/** @ReferenceMany(targetDocument="Documents\Tag")*/
	private $tags; 
	public function __construct(){
	   $this->tags = new \Doctrine\Common\Collections\ArrayCollection();	
	}
	public function getTag(){
		return $this->tags;
	}
	public function setTag($tags){
		$this->tags = $tags;
	}
	public function addUserTag(Documents\Tag $tag){
		$this->tags[] = $tag;
	}
}