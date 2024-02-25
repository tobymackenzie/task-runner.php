<?php
namespace TJM\TaskRunner\Tests;
use PHPUnit\Framework\TestCase;
use TJM\TaskRunner\Tests\Tasks\ArraySetTask;
use TJM\TaskRunner\Tests\Tasks\ShouldTask;
use TJM\TaskRunner\Tests\Tasks\ShouldNotTask;

class TaskTest extends TestCase{
	public function testSimpleDoUndoDid(){
		$task = new ShouldTask();
		$this->assertFalse($task->didDo());
		$task->do();
		$this->assertTrue($task->didDo());
		$task->undo();
		$this->assertFalse($task->didDo());
	}
	public function testShouldNot(){
		$task = new ShouldNotTask();
		$task->do();
		$this->assertTrue(!$task->didDo());
		$task->undo();
		$this->assertTrue(!$task->didDo());
	}
	public function testSimpleDoUndoSideAffects(){
		$GLOBALS['a'] = [];
		$task = new ArraySetTask('a');
		$task->do();
		$this->assertTrue($GLOBALS['a'][0] === 'a');
		$task->undo();
		$this->assertTrue(empty($GLOBALS['a']));
		unset($GLOBALS['a']);
	}
}
