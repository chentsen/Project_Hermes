<?php
class Application_Model_InterestModel{
	public $interest;
	public function __construct($interest){
		$this->interest = $interest;
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
	}
	public function addUserTag($tag){
		$this->interest->addUserTag($tag);
		$this->dm->persist($this->interest);
		$this->dm->flush();
	}
	public function deleteUserTag($tagName){
		$tags = $this->interest->getTags();
		if($tags){
				//super slow search -- refactor later
				for($i = 0;$i<count($tags);$i++ ){
					if($tags[$i]->getTagName() == $tagName){
						unset($tags[$i]);
						if($tags)
							$this->interest->setTags( Application_Model_Utils_CollectionUtil::collection_values($tags));
						$this->dm->persist($this->interest);
						$this->dm->flush();
						return true;
					}
				}
				return false;
			}else{
				return false;
			}
		}
	public function hasTag($tagName){
		$tags = $this->interest->getTags();
		foreach($tags as $tag){
			try{
				if($tag->getTagName()==$tagName)
					return true;	
			}catch(Exception $ex){
				error_log("Exception thrown in hasTag: "+$ex->getMessage());
			}
		}
		return false;
	}
	public function getTags(){
		$lazy_tags = $this->interest->getTags();
		$realTags = array();
		
		for($i = 0;$i<count($lazy_tags);$i++){
			try{
				//Make sure the tag is valid!
				$lazy_tags[$i]->getTagName();
				//if that went through then this tag is real
				$realTags[] = $lazy_tags[$i];
			}
			catch(Exception $ex){
				$hasFlush = true;
				$lazy_tags[$i] = null;
				//not sure if this actually indexes it
				
				
				
				
			}
			
		}
		if($hasFlush){
			array_values($lazy_tags);
			if(empty($lazy_tags)){
				$lazy_tags = null;
			}
			$this->interest->setTags($lazy_tags);
			$this->dm->persist($this->interest);
			$this->dm->flush();
		}
		return $realTags;
	}
	public function getActivatedTags(){
		$tags = $this->interest->getTags();
		$activatedTags = array();
		$states = $this->interest->getState();
		foreach($tags as $tag){
			if($states[$tag->getTagName()])
				$activatedTags[] = $tag;
		}
		return $activatedTags;
	}
	public function disableTag($tagName){
		$this->interest->state[$tagName] = false;
	}
	public function enableTag($tagName){
		$this->interest->state[$tagName] = true;
	}
	public function toggleTag($tagName){
		 $state = $this->interest->getState();
		 //var_dump($state);
		if($state[$tagName]){
			$state[$tagName] = false;
		}else{
			$state[$tagName] = true;
		}
		$this->interest->state = $state;
		$this->dm->persist($this->interest);
		$this->dm->flush();
	}
}