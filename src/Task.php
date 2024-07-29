<?php
namespace TJM\TaskRunner;
use Exception;

class Task implements TaskInterface{
	protected $dependencies = [];

	//==operations
	public function __invoke(){
		return $this->do();
	}
	public function do(){
		throw new Exception("Task " . get_class($this) . " has no `do()` method implemented.");
	}
	public function shouldDo(){
		return true;
	}
	public function undo(){
		throw new Exception("Task " . get_class($this) . " has no `undo()` method implemented.");
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
	public function getId(){
		return get_class($this);
	}
}
