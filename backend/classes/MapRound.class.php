<?php

class MapRound extends MapObject {
	
	private $location = null;
	private $radius = null;
	
	public function __construct(Location $location, int $radius) {
		$this -> location = $location;
		$this -> radius = $radius;
	}
	
	public function getPositionData() : array {
		return array($this -> location, $this -> radius);
	}
	
}