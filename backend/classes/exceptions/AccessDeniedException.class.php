<?php

class AccessDeniedException extends Exception {
	
	public function __construct(string $message) {
		parent::__construct("Access denied. $message");
	}
	
}