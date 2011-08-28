<?php
		
		$options = array
			(
			    'hostname' => 'localhost',   
			    'port'     => 8080,
				'path'	   =>'/solr/',
				
			);
	
		$client = new SolrClient($options);
		$query = new SolrQuery();
		$query->setStart(0);

$query->setRows(50);
		$query->setQuery('andy');

		//$query->addField('users_firstName');
		$query_response = $client->query($query);
			$response = $query_response->getResponse();
		
		
		$documents = $response['response']['docs'];
		foreach($documents as $document){
			if($document['users_email2']==''){
				echo 'exists';
			}
		}
		
	//	print_r($documents);
		?>