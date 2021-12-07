<?php
namespace TJM\TaskRunner\Tests\Tasks;
use TJM\TaskRunner\Task;

class ShouldNotTask extends Task{
	public function shouldDo(){
		return false;
	}
}
