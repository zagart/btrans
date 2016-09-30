<?php

abstract class Algorithm extends StrictAccessClass {
	
	public abstract function execute(Core $core, TimeLimiter $timeLimiter) : array;
	
}