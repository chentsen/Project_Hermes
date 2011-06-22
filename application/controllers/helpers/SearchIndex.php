<?php
class Zend_Controller_Action_Helper_SearchIndex extends Zend_Controller_Action_Helper_Abstract{
	
	public function search($queryString,$mongoContainer){
		
		$searchModel = new Application_Model_Search_Search($mongoContainer);
		//echo "I'm HERE";
		$searchModel->search($queryString);
		
		$results = $searchModel->getResults();
		
		return $results;
	}
	
}