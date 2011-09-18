<?php
use Documents\Tag;
class Application_Model_TagModel{
	private $tagArray;
	private $currentTag;
	private $user;
	private $rankedTagArray;
	public function __construct(Documents\User $user = null){
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$this->user = $user;
		if($this->user){
			$userInterest = $this->user->getInterest();
			$this->interestModel = new Application_Model_InterestModel($userInterest);	
			
		}
		$this->setTagArray();
	}
	/**
	 * 
	 * Returns a list of tags that have a count above countNumberLimit
	 * @param unknown_type $countNumberLimit
	 */
	public function setRankedTags($countNumberLimit)
	{
		
		foreach($this->tagArray as $tag){
			if($tag->getCount() >= $countNumberLimit)
				$this->rankedTagArray[] = $tag;	
		}		
	}
	public function getRankedTags(){
		return $this->rankedTagArray;
	}
	
		/**
	 * 
	 * If tag exists then increment count, and add tag to user's interest model else,
	 * serialize a new entry and then add
	 * @param unknown_type $tagName
	 */
	public function addTag($tagName,$isCurated = false){
		$tagKey = $this->tagExists($tagName);
		if(!$this->interestModel->hasTag($tagName)){
			if($tagKey){
				if($tagKey == 'zero')
					$tagKey = 0;
				//echo 'WITHIN TAG KEY BRANCH key is'.$tagKey;
				//print_r($this->tagArray[$tagKey]);
				$this->tagArray[$tagKey]->incrementCount();
				$this->dm->persist($this->tagArray[$tagKey]);
				$this->interestModel->addUserTag($this->tagArray[$tagKey]);
				$this->dm->flush();
			}else{
				$newTag = new Tag(array('tagName'=>$tagName,'isCurated'=>$isCurated));
				$this->dm->persist($newTag);
				$this->interestModel->addUserTag($newTag);
				$this->dm->flush();
			}
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
	private function deleteTag($tagName){
		$this->interestModel->deleteTag($tagName);
		if($this->tagExists($tagName)){	
			if($tagKey == 'zero')
				$tagKey = 0;
			$tag = $this->tagArray[$tagKey];
			$tag->decrementCount();
			if($tag->getCount == 0){
				$this->dm->remove($tag);
			}else{
				$this->dm->persist($tag);
			}
		}	
		$this->dm->persist();
		
	}
	/**
	 * 
	 * Checks to see if the tag exists
	 * @param unknown_type $tagName
	 */
	private function tagExists($tagName){
		if($this->tagArray){
			//super slow search -- refactor later
			foreach($this->tagArray as $key => $tag ){
				//echo 'new tag is '. $tagName;
			//	echo $tag->getTagName()."<br>";
				if($tag->getTagName() == $tagName){
					//echo 'tag exists returning key';
					if($key == 0){
						return 'zero';
					}
					return $key;
				}
			}
			return false;
		}else{
			return false;
		}
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
	private function setTagArray($countNumber = 1,$limit = 1000){
		$query = $this->dm->createQueryBuilder('Documents\Tag')->find()->limit($limit)->sort('count', 'desc');
		$statement = $query->getQuery();
		$tagCursor = $statement->execute();
		if($tagCursor){
			foreach($tagCursor as $tag){
				//echo 'IN THE LOOP';
				$this->tagArray[] = $tag;
			}
		}else{
			exit;
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