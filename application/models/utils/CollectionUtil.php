<?php
class Application_Model_Utils_CollectionUtil{
	//reindex
	public static function collection_values(Doctrine\ODM\MongoDB\PersistentCollection $collection){
		
		foreach($collection as $object){
			$newCollection[] = $object;
		}
		return $newCollection;	
	}
}