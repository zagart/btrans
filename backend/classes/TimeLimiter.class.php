<?php

class TimeLimiter extends StrictAccessClass {
	
	private $minTime;
	private $maxTime;
	
	public function __construct(int $minTime, int $maxTime) {
		$this -> minTime = $minTime;
		$this -> maxTime = $maxTime;
	}
	
	public function getMinTime() : int {
		return $this -> minTime;
	}	
	
	public function getMaxTime() : int {
		return $this -> maxTime;
	}
	
	public function isRequiredTime(int $time) : bool {
		if ($time <= $this -> maxTime and $time >= $this -> minTime) {
			return true;
		} else {
			return false;
		}
	}
	
}