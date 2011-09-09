<?php
class BaseModel{
	public function __construct($mongoContainer){
		$this->dm = $mongoContainer->getDocumentManager('default');

	}
}