<?php
namespace TJM\TaskRunner;

interface TaskInterface{
	public function dependsOn();
	public function didDo();
	public function do();
	// function shouldDo(): whether task should be run in current iteration.  Will not stop other tasks
	public function shouldDo();
	public function undo();
}
