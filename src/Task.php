<?php
namespace TJM\TaskRunner;
use DateTime;

class Task implements TaskInterface{
	protected $did = [];
	protected $dependencies = [];

	//==operations
	public function didDo(){
		return count($this->did) > 0;
	}
	public function do(){
		if($this->shouldDo()){
			$this->did[] = new DateTime();
		}
	}
	public function shouldDo(){
		return true;
	}
	public function undo(){
		$this->did = [];
	}

	//==dependencies
	public function addDependency($dependency){
		$this->dependencies[] = $dependency;
		return $this;
	}
	public function dependsOn(){
		return $this->dependencies;
	}
	public function setDependencies($dependency){
		$this->dependencies[] = $dependency;
		return $this;
	}
}
