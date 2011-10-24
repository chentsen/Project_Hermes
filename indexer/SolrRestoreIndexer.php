<?php
//Define the collections which each comes from, tokenize for Mongo Processing
define("USERS","doctrine.users");
$tokenized = preg_split('/[.]/',USERS);
define("USERS_DB",$tokenized[0]);
define("USERS_COLLECTION",$tokenized[1]);
//Define collections, and dbs for events
define("EVENT","doctrine.event");
$tokenized = preg_split('/[.]/',EVENT);
define("EVENT_DB",$tokenized[0]);
define("EVENT_COLLECTION",$tokenized[1]);

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
	
		
	/** Updates and refills index with everything that is currently in the oplog	*/
	function runBackupIndex(){
              $this->cursor = $this->collection->find()->tailable(true);
	      //$lastValue = $this->collection->find()->
	      //$this->cursor = $this->collection->find(array('increasing'=>array('$gte'=>$lastValue)))->tailable(true);	
		$count = 0;
		while(true){				
				if($this->cursor->hasNext()){
	      				  while($this->cursor->hasNext()){
						   $document = $this->cursor->getNext();					
						   $updatedDocument = $this->processObject($document);
						   //print_r($updatedDocument);
						   if($updatedDocument){
							   $this->client->addDocument($updatedDocument);
							//   echo 'Updated something!';
							   $count++;
						   }
					  }
                                          $this->client->commit();
					  echo $count.' elements restored!';
					  //delay this for several cycles once it's necessary				
										  //maybe want to abstract this into an object later.
				   }	  //also want to redo this code so that it upserts the data into the given object id instead of finding the collection each time
			        
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
			case EVENT:
				return $this->processEvent($document);		
			default:
				return null; 
		}
	}
	//need to refactor later to not find one all the time-- should pull all updated objects
	private function processUser($document){
		//echo 'ENTERING USERS';
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
   private function processEVENT($document){
		
   		$db = $this->mongo->selectDB(EVENT_DB);
		$updatedCollection = $db->selectCollection(EVENT_COLLECTION);
	
		$updatedDocument = $updatedCollection->findOne(array('_id'=>$document['o']['_id']));
		//echo 'DOCID == '.$document['o']['_id'];
		
		if($updatedDocument){
			//print_r($updatedDocument);
			$doc = new SolrInputDocument();
			$doc->addField('id', $updatedDocument['_id']);
			
			$db = $this->mongo->selectDB(USERS_DB);
			//echo 'THIS IS THE USER OBJECT ID'.$updatedDocument['creator']['$id'];
			$usersCollection = $db->selectCollection(USERS_COLLECTION);
			$usersDocument = $usersCollection->findOne(array('_id'=>$updatedDocument['creator']['$id']));
			$doc->addField('event_creatorFirstName', $usersDocument['firstName']);
			
			$doc->addField('event_creatorLastName', $usersDocument['lastName']);
			$doc->addField('event_location', $updatedDocument['location']);
			
			$doc->addField('event_shortDescription', $updatedDocument['shortDescription']);
			
			$doc->addField('event_longDescription', $updatedDocument['longDescription']);
			$mongoDate = new MongoDate($updatedDocument['date']->sec);
			$dateString = date('Y-M-d h:i:s', $mongoDate->sec);
			//echo 'DATE IS'.$mongoDate->__toString();
			$doc->addField('event_date', $dateString);
			
			return $doc;
		}
		
		
	}
 }

 $indexer = new SolrIndexer();
 $indexer->runBackupIndex();
	
?>