<?php
namespace TJM\TaskRunner\Tests\Tasks;
use TJM\TaskRunner\Task;

class ArraySetTaskTwo extends ArraySetTask{
	protected $value = 'two';
	public function dependsOn(){
		return 'TJM\TaskRunner\Tests\Tasks\ArraySetTaskOne';
	}
}
