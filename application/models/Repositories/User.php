<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;

class User extends DocumentRepository{

		
	/*
	public function findOneByEmail($email){
		$bootstrap = $this->getInvokeArg('bootstrap');
    	$mongoContainer = $bootstrap->getResource('DoctrineMongoContainer');
    	$this->dm = $mongoContainer->getDocumentManager('default');
		$user = $this->dm->getRepository('Documents\User')->findOneBy(array('email'=>$email));
		return $user;
	}*/
}