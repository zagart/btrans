<?php

class IllegalArgumentException extends Exception {
	
	public function __construct(string $message = "") {
		parent::__construct("Incorrect variable/object. $message");
	}
	
}