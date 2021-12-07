<?php
namespace TJM\TaskRunner\Tests\Tasks;
use TJM\TaskRunner\Task;

class ArraySetTaskThree extends ArraySetTask{
	protected $value = 'three';
	public function dependsOn(){
		return 'TJM\TaskRunner\Tests\Tasks\ArraySetTaskTwo';
	}
}
