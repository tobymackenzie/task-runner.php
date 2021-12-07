<?php
namespace TJM\TaskRunner\Tests\Tasks;
use TJM\TaskRunner\Task;

class ArraySetTask extends Task{
	protected $value;
	public function __construct($value = null){
		if(isset($value)){
			$this->value = $value;
		}
	}
	public function do(){
		if(!isset($GLOBALS['a'])){
			$GLOBALS['a'] = [];
		}
		$GLOBALS['a'][] = $this->value;
		parent::do();
	}
	public function undo(){
		if($this->did){
			if(!isset($GLOBALS['a'])){
				$GLOBALS['a'] = [];
			}
			$index = array_search($this->value, $GLOBALS['a']);
			if($index !== false){
				unset($GLOBALS['a'][$index]);
			}
			parent::undo();
		}
	}
}
