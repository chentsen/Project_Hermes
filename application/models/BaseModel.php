<?php
abstract class Application_Model_BaseModel{
	protected $dm;
	public function __construct(){
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
	}
}