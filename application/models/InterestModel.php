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
			if($tag->getTagName()==$tagName)
				return true;	
		}
		return false;
	}
	public function getTags(){
		return $this->interest->getTags();
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