<?php
namespace TJM\TaskRunner\Tests;
use PHPUnit\Framework\TestCase;
use TJM\TaskRunner\TaskSet;
use TJM\TaskRunner\Tests\Tasks\ArraySetTask;
use TJM\TaskRunner\Tests\Tasks\ArraySetTaskOne;
use TJM\TaskRunner\Tests\Tasks\ArraySetTaskThree;
use TJM\TaskRunner\Tests\Tasks\ArraySetTaskTwo;
use TJM\TaskRunner\Tests\Tasks\ShouldNotTask;

class TaskSetTest extends TestCase{
	public function testSimpleDoUndoDid(){
		$tasks = new TaskSet();
		$this->assertTrue($tasks->didDo(), 'Empty task set should be done always');
		$tasks->do();
		$this->assertTrue($tasks->didDo(), 'Empty task set should be done after do');
		$tasks->undo();
		$this->assertTrue($tasks->didDo(), 'Empty task set should still be done after undo');
	}
	public function testShouldNotDid(){
		$tasks = new TaskSet([new ShouldNotTask()]);
		$this->assertTrue(!$tasks->didDo());
		$tasks->do();
		$this->assertTrue($tasks->didDo());
		$tasks->undo();
		$this->assertTrue(!$tasks->didDo());
	}
	public function testSimpleDoUndoSideAffects(){
		$GLOBALS['a'] = [];
		$tasks = new TaskSet([
			new ArraySetTask('a')
		]);
		$tasks->do();
		$this->assertTrue($GLOBALS['a'][0] === 'a');
		$tasks->undo();
		$this->assertTrue(empty($GLOBALS['a']));
		unset($GLOBALS['a']);
	}
	public function testSimpleDependency(){
		$GLOBALS['a'] = [];
		$tasks = new TaskSet([
			new ArraySetTaskThree(),
			new ArraySetTaskTwo(),
			new ArraySetTaskOne(),
		]);
		$tasks->do();
		$this->assertTrue($GLOBALS['a'][0] === 'one');
		$this->assertTrue($GLOBALS['a'][1] === 'two');
		$this->assertTrue($GLOBALS['a'][2] === 'three');
		$this->assertTrue($tasks->didDo());
		$tasks->undo();
		$this->assertTrue(empty($GLOBALS['a']));
		$this->assertTrue(!$tasks->didDo());
		unset($GLOBALS['a']);
	}
	public function testNestedDependency(){
		$GLOBALS['a'] = [];
		//-! can nest but can't depend on tasks from another set.  create DoneList, share between?
		$tasks = new TaskSet([
			new TaskSet([
				new ArraySetTaskThree(),
				new ArraySetTaskTwo(),
				new ArraySetTaskOne(),
			]),
			new ArraySetTaskOne(),
		]);
		$tasks->do();
		$this->assertTrue($GLOBALS['a'][0] === 'one');
		$this->assertTrue($GLOBALS['a'][1] === 'two');
		$this->assertTrue($GLOBALS['a'][2] === 'three');
		$this->assertTrue($GLOBALS['a'][3] === 'one');
		$this->assertTrue($tasks->didDo());
		$tasks->undo();
		$this->assertTrue(empty($GLOBALS['a']));
		$this->assertTrue(!$tasks->didDo());
		unset($GLOBALS['a']);
	}
	public function testSimpleDependencyFailure(){
		unset($GLOBALS['a']);
		$this->expectException('Exception');
		$tasks = new TaskSet([
			new ArraySetTaskThree(),
			new ArraySetTaskTwo(),
		]);
		$tasks->do();
		$this->assertTrue(!$tasks->didDo());
		$this->assertTrue(empty($GLOBALS['a']));
	}
}
