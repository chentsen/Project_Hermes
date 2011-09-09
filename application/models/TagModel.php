<?php
use Documents\Tag;
class TagModel{
	private $tagArray;
	private $currentTag;
	private $user;
	public function __construct(Documents\User $user = null){
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$this->user = $user;
		if($this->user){
			$userInterest = $this->user->getInterest();
			$this->interestModel = new InterestModel($userInterest);	
		}
	}
	/**
	 * 
	 * If tag exists then increment count, and add tag to user's interest model else,
	 * serialize a new entry and then add
	 * @param unknown_type $tagName
	 */
	public function addTag($tagName,$isCurated = false){
		
		if($tagKey = $this->tagExists($tagName)){
			$this->tagArray[$tagKey]->incrementCount();
			$this->dm->persist($this->tagArray[$tagKey]);
			$this->interestModel->addUserTag($this->tagArray[$tagKey]);
			$this->dm->flush();
		}else{
			$newTag = new Tag(array('tagName'=>$tagName,'isCurated'=>isCurated));
			$this->interestModel->addUserTag($this->tagArray[$tagKey]);
			$this->dm->persist($newTag);
			$this->dm->flush();
		}
	}
	/**
	 * 
	 * Gets the number of times a tag has been added to profile pages (as shown in DB)
	 * @param unknown_type $tag
	 */
	public function getCount($tag){
		return $this->tag->getCount();
	}
	/**
	 * 
	 * Validates the tag somehow TBA.
	 * @param unknown_type $tag
	 */
	public function validateTag($tag){
		
	}
	/**
	 * 
	 * To be called when the tag exists and should be incremented in the DB
	 * @param unknown_type $tag
	 */
	public function incrementCount(Documents\Tag $tag){
		$tag->incrementCount();
	}
	/**
	 * 
	 * Decreases the count (represents # of appearances in DB)
	 * @param unknown_type $tag
	 */
	public function decrementCount($tag){
		$tag->decrementCount();
	}
	/**
	 * 
	 * Deletes the tag from the user
	 * @param unknown_type $tag
	 */
	private function deleteTag($tag){
		$this->interestModel->deleteTag($tag);
		$tag->decrementCount();
		if($tag->getCount == 0){
			$this->dm->remove($tag);
		}else{
			$this->dm->persist($tag);
		}
		$this->dm->persist();
		
	}
	/**
	 * 
	 * Checks to see if the tag exists
	 * @param unknown_type $tagName
	 */
	private function tagExists($tagName){
		return array_search($tagname,$this->tagArray);
	}
	/**
	 * 
	 * Sorts the tag array by it's count number.
	 */
	public function sortTags(){
		function cmp( $a, $b )
		{ 
		  if(  $a->getCount() ==  $b->getCount() ){ return 0 ; } 
		  return ($a->getCount() < $b->getCount()) ? -1 : 1;
		} 
		$this->tagArray = usort($this->tagArray, 'cmp');
	}
	/**
	 * Gets a list of tags from mongoDB with a count attribute greater than countNUmber
	 */
	//gets the tags from mongoDB
	private function setTagArray($countNumber,$limit = 1000){
		$tagCursor = $this->dm->createQueryBuilder('Documents\Tag')->find()->limit($limit)->
		sort('count', 'desc');
		foreach($tagCursor as $tag){
			$this->tagArray[] = $tag;
		}
	}
	/**
	 * 
	 * returns the tag array
	 * @param unknown_type $limit
	 */
	public function getTagArray(){
		return $this->tagArray;
	}
	
}