<?php
namespace TJM\TaskRunner;

interface TaskInterface{
	//==operations
	public function __invoke();
	public function do();
	public function shouldDo();
	public function undo();

	//==dependencies
	public function dependsOn();
	public function getId();
}
