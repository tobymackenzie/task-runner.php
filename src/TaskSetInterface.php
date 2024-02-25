<?php
namespace TJM\TaskRunner;

interface TaskSetInterface extends TaskInterface{
	public function didDo();
}
