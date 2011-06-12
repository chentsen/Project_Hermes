<?php
//Define the collections which each comes from, tokenize for Mongo Processing
define("USERS","doctrine.users");
$tokenized = preg_split('/[.]/',USERS);
define("USERS_DB",$tokenized[0]);
define("USERS_COLLECTION",$tokenized[1]);
$userObject = $tokenized[1];
//solr indexer options
	
	
 class SolrIndexer{
	private $mongo;
	private $collection;
	private $cursor;
	private $client;
	/*
	$doc->addField('id', 334455);
	$doc->addField('cat', 'Software');
	$doc->addField('cat', 'Lucene');
	$doc->addField('features','PHP and why it rocks');
	$doc->addField('features','PHP and why it rocks2');
	$updateResponse = $client->addDocument($doc);
	print_r($updateResponse->getResponse());*/
	
	//$document = new SolrDocument();
	//$mongo = new Mongo(Zend_Registry::get('config')->siteInformation->mongoDB);
	//the main instance of mongo to tail
	function __construct(){
		$options = array
			(
			    'hostname' => 'localhost',   
			    'port'     => 8080,
				'path'	   =>'/solr/',
				
			);
		try{
			$this->client = new SolrClient($options);
			
		}catch(Exception $e){
			echo ('Exception is' +$e);
		}
	
		$this->mongo = new Mongo("mongodb://localhost:27017");
		
		$db = $this->mongo->selectDB('local');
		$this->collection = $db->selectCollection('oplog.rs');
		
	}
	
		
		
	function runIndex(){
		$this->cursor = $this->collection->find()->tailable(true);
		while(true){				
				if($this->cursor->hasNext()){
					$document = $this->cursor->getNext();					
					//print_r($document);
					//echo 'found updated object..';
					$updatedDocument = $this->processObject($document);
					if($updatedDocument){
						$this->client->addDocument($updatedDocument);
						$this->client->commit();
						echo 'Updated something!';
					}
					//delay this for several cycles once it's necessary				
										//maybe want to abstract this into an object later.
					//also want to redo this code so that it upserts the data into the given object id instead of finding the collection each time
				}
				else{
					echo 'Sleeping';
					sleep(10);
				}
			}
	}
	
	private function processObject($document){
		//echo 'document namespace is '.$document['ns'];
		//echo 'Users is '.USERS; 
		switch($document['ns']){
			case USERS:
				return $this->processUser($document);		
			default:
				return null; 
		}
	}
	private function processUser($document){
		$db = $this->mongo->selectDB(USERS_DB);
		$updatedCollection = $db->selectCollection(USERS_COLLECTION);
		$updatedDocument = $updatedCollection->findOne(array('_id'=>$document['o']['_id']));
		if($updatedDocument){
			$doc = new SolrInputDocument();
			$doc->addField('id', $updatedDocument['_id']);
			$doc->addField('users_email', $updatedDocument['email']);
			$doc->addField('users_firstName', $updatedDocument['firstName']);
			$doc->addField('users_lastName', $updatedDocument['lastName']);
			return $doc;
		}
		
	}
 }
 $indexer = new SolrIndexer();
 $indexer->runIndex();
	
?>