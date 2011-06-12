<?php
class Application_Model_Search_Search{
	private $client;
	private $results;
	private $process;
	private $dm;
	public function __construct($mongoContainer){
			$this->client = Zend_Registry::get('solr');	
			$this->dm = $mongoContainer->getDocumentManager('default');
			$this->process = new Application_Model_Search_Process($this->dm);
			$this->results = array();
	}
	
	public function search($queryString){
		$query = new SolrQuery();
		$query->setStart(0);
		$query->setRows(50);
		$query->setQuery($queryString);
		$query_response = $this->client->query($query);
		$response = $query_response->getResponse();
		$documents = $response['response']['docs'];
		if($response['response']['docs']!=''){
			foreach($documents as $document){
				$this->results[] = $this->process->process($document);
			}	
		}
		else
			$this->results = null;
	}
	public function getResults(){
		return $this->results;
	}
	
}