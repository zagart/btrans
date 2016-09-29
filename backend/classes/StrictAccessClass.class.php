<?php

abstract class StrictAccessClass {
		
	public function __get(string $name) {
		throw new AccessDeniedException("Getting of properties is available only threw direct getters ");
	}
	
	public function __set(string $name, $value) {
		throw new AccessDeniedException("Setting of properties is available only threw direct setters ");
	}
	
}