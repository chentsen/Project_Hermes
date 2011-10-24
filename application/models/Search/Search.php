<?php
class Application_Model_Search_Search{
	private $client;
	private $eventResults;
	private $userResults;
	private $process;
	private $dm;
	private $user;
	private $currentUser;
	public function __construct($mongoContainer,$user){
			$this->client = Zend_Registry::get('solr');	
			$this->dm = $mongoContainer->getDocumentManager('default');
			$this->process = new Application_Model_Search_Process($this->dm);
			$this->currentUser = $user;
	}
	
	public function search($queryString,$rankByTags = true){
		$query = new SolrQuery();
		$query->setStart(0);
		$query->setRows(50);
		$query->setQuery($queryString);
		$query_response = $this->client->query($query);
		$response = $query_response->getResponse();
		$documents = $response['response']['docs'];
		if($response['response']['docs']!=''){
			foreach($documents as $document){		
				$object = $this->process->process($document);
				if($object instanceof Documents\Event)
					$this->eventResults[] = new Documents\Search\EventResult($object);	
				else if($object instanceof Documents\User)			
					$this->userResults[] =  new Documents\Search\UserResult($object);	
			}
			if($rankByTags){
				$this->eventResults = $this->doRankEventByTags($this->eventResults);
				$this->userResults = $this->doRankUserByTags($this->userResults);
			}	
		}
		else{
		//	echo 'THIS SHIT IS BEING INEXPLICABLY CALLED';
			$this->results = null;	
			
		}
	}
	public function getResults(){
	//	echo "I'm HERE";
		//echo count($this->results);
		return array('eventResults'=>$this->eventResults,'userResults'=>$this->userResults);
	}
	/**
	 * 
	 * Ranks the event results according to # of tag matches
	 */
	private function doRankEventByTags($results){
		$userInterestModel = new Application_Model_InterestModel($this->currentUser->getInterest());
		$userTags = $userInterestModel->getActivatedTags();
		
		if($results){
			foreach($results as &$result){
				$interest = new Application_Model_InterestModel($result->result->getCreator()->getInterest());	
				if(count($userTags)>1){
					//echo 'MORE THAN 1 TAG';
					foreach($userTags as $userTag){
						if($interest->hasTag($userTag->getTagName())){
							$result->match[]=$userTag;	
						}	
					}
				}else if(count($userTags) == 1){
					//echo 'LESS THAN 1 TAG';
					if($interest->hasTag($userTags[0]->getTagName()))
					//echo $userTags->getTagName();	
					$result->match[]=$userTags[0];	
				}
			}
			$this->sortResults($results);
			return $results;
		}else return;
	}

		
	private function doRankUserByTags($results){
	
		$userInterestModel = new Application_Model_InterestModel($this->currentUser->getInterest());
		$userTags = $userInterestModel->getActivatedTags();
		if($results){
			foreach($results as &$result){
				$interest = new Application_Model_InterestModel($result->result->getInterest());			
				if(count($userTags)>1){
					foreach($userTags as $userTag){
						if($interest->hasTag($userTag->getTagName())){
							$result->match[]=$userTag;	
						}	
					}
				}else if(count($userTags) == 1){
					if($interest->hasTag($userTags[0]->getTagName()))
					//echo $userTags->getTagName();	
						$result->match[]=$userTags[0];	
				}
			}
			//var_dump($results);
			$this->sortResults($results);
			//print_r($results[0]->match->getTagName());
			return $results;
		}else return;
	}
	
	private function sortResults(&$results){
		
		usort($results, 'Search_cmpResults');
	}
	
	
}
function Search_cmpResults( $a, $b )
		{ 
		  if(  $a->getCount() ==  $b->getCount() ){ return 0 ; } 
		  return ($a->getCount() > $b->getCount()) ? -1 : 1;
		} 