<?php
namespace TJM\TaskRunner;
use DateTime;
use Exception;

class TaskSet extends Task implements TaskSetInterface{
	protected $done = [];
	protected $tasks = [];
	public function __construct(array $tasks = null){
		if(is_array($tasks)){
			$this->tasks = $tasks;
		}
	}
	//==collection
	protected function deferTask(TaskInterface $task){
		$dependencies = $task->dependsOn();
		if($dependencies){
			foreach(is_array($dependencies) ? $dependencies : [$dependencies] as $dependency){
				if(!$this->hasDone($dependency)){
					return true;
				}
			}
		}
		return false;
	}
	protected function hasDone($task){
		if(is_string($task)){
			foreach($this->done as $done){
				if($done instanceof TaskInterface && $done->getId() === $task){
					return true;
				}
			}
		}elseif($task instanceof TaskInterface){
			foreach($this->done as $done){
				if($done instanceof TaskInterface && $done === $task){
					return true;
				}
			}
		}
		return false;
	}

	//==operations
	public function do(){
		$remainingTasks = array_reverse($this->tasks);
		if($remainingTasks){
			$nonDeferredRemainingCount = 0;
			while(count($remainingTasks)){
				$task = array_pop($remainingTasks);
				if($this->deferTask($task)){
					array_unshift($remainingTasks, $task);
					if(++$nonDeferredRemainingCount > count($remainingTasks) + 1){
						break;
					}
				}else{
					if($task->shouldDo($this)){
						$task->do();
					}
					$this->done[] = $task;
					$nonDeferredRemainingCount = 0;
				}
			}
		}
		if(count($this->done) !== count($this->tasks)){
			throw new Exception(get_class($this) . ': ' . count($remainingTasks) . ' tasks were not complete');
		}else{
			$this->did[] = new DateTime();
		}
	}
	public function undo(){
		foreach($this->tasks as $task){
			if($task->didDo()){
				$task->undo();
			}
		}
		$this->did = [];
	}
}
