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