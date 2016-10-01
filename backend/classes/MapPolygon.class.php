<?php

class MapPolygon extends MapObject {
	
	public function getPositionData() : array {
		return array();
	}
	
	public function isContainsLocation(Location $location) : bool {
		return false;
	}
	
}