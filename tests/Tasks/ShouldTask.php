<?php
namespace TJM\TaskRunner\Tests\Tasks;
use TJM\TaskRunner\Task;

class ShouldTask extends Task{
	protected $did = false;
	public function do(){
		if($this->shouldDo()){
			$this->did = true;
		}
	}
	public function didDo(){
		return $this->did;
	}
	public function undo(){
		if($this->did){
			$this->did = false;
		}
	}
}
