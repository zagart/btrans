<?php

class TimeLimiter extends StrictAccessClass {
	
	const MINUTE = 60;
	const TEN_MINUTES = 600;
	const HOUR = 3600;
	const DAY = 86400;
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