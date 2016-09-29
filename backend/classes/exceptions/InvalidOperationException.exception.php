<?php

class InvalidOperationException extends Exception {
	
	public function __construct(string $message = "") {
		parent::__construct("Calling of method failed. $message");
	}
	
}