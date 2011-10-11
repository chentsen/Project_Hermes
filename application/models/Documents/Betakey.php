<?php
namespace Documents;

/** @Document(collection="betakey", repositoryClass="Repositories\Betakey")*/
class Betakey {
	/** @Id*
	 *  
	 */
	private $id;
	/** @Field(type="string")*/
	private $key;
	/** @Field(type="boolean")*/
	private $used;
	public function __construct(){
		$this->key = uniqid(rand(),false);
	}
	public function getKey(){
		return $this->key;
	}
}