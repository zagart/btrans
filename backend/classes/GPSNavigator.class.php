<?php

class GPSNavigator extends StrictAccessClass implements Locatable {
	
	private $id = 0;
	private $archive = array();
	
	public function addLocation($location) {
		if ($location instanceof Location) {
			$this -> archive[] = $location;
		} else {
			throw new IllegalArgumentException("Object of class Location expected");
		}
	}
	
	public function getLocationsArchive() : array {
		return $this -> archive;
	}
		
}
