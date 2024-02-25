<?php
namespace TJM\TaskRunner\Tests\Tasks;

class ShouldNotTask extends ShouldTask{
	public function shouldDo(){
		return false;
	}
}
