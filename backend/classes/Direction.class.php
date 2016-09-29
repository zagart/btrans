<?php

class Direction extends StrictAccessClass {
	
	private static $counter = 0;
	
	private $id = 0;
	private $startLocation = null;
	private $endLocation = null;
	
	public function __construct(Location $startLocation, Location $endLocation) {
		$this -> startLocation = $startLocation;
		$this -> endLocation = $endLocation;	
		self::$counter++;
		$this -> id = self::$counter;
	}
	
	public function getEndLocation() : Location {
		return $this -> endLocation;
	}
	
	public function getId() : int {
		return $this -> id;
	}
	
	public function getStartLocation() : Location {
		return $this -> startLocation;
	}
	
}