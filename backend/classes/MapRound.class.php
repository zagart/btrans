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
	
	public function isContainsLocation(Location $location) : bool {
		if ($this -> location -> distanceTo($location) <= $this -> radius) {
			return true;
		} else {
			return false;
		}
	}
	
}