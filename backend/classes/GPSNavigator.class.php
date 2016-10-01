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
	
	public function getAverageLocation() : Location {
		if (!empty($this -> archive)) {
			$counter = 0;
			$azimuth = 0; 
			$lat = 0; 
			$lng = 0; 
			$timestamp = 0; 
			$speed = 0;
			foreach ($this -> archive as $location) {
				$azimuth = $location -> getAzimuth(); 
				$lat += $location -> getLatitude(); 
				$lng += $location -> getLongitude(); 
				$timestamp += $location -> getTimestamp(); 
				$speed += $location -> getSpeed(); 
				$counter++;
			}
			$azimuth /= $counter; 
			$lat /= $counter; 
			$lng /= $counter; 
			$timestamp /= $counter; 
			$speed /= $counter; 
			return new Location(
				$lat, 
				$lng, 
				$timestamp, 
				$azimuth,
				$speed
			);
		} else {
			throw new InvalidOperationException("Locations archive is empty. Firstly add locations");
		}
	}
	
	public function getId() : int {
		return $this -> id;
	}
	
	public function getLocationsArchive() : array {
		return $this -> archive;
	}
		
}
