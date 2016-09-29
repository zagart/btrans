<?php

class GPSNavigator extends StrictAccessClass implements Locatable {
	
	private $id = 0;
	private $archive = array();
	
	public function __construct(int $id) {
		$this -> id = $id;
	}
	
	public function addLocation(Location $location) {
		$this -> archive[] = $location;
	}
	
	public function getId() : int {
		return $this -> id;
	}
	
	public function getLocationsArchive() : array {
		return $this -> archive;
	}
		
}
