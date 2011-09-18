<?php 
namespace Documents\Search;
//wrapped
abstract class Result{
	public $result;
	public $match;
	public function getCount(){
		return count($this->match);
	}
	public function __construct($result){
		$this->result = $result;
	}
}

?>