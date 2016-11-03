<?php

class Transport {
	
	private static $counter = 0;
	
	private $gps = null;
	private $id = 0;
	private $route = "";
	private $type = 0;
	
	public function __construct(string $route, int $type) {
		$this -> route = $route;
		$this -> type = $type;
		self::$counter++;
		$this -> id = self::$counter;
	}
	
	public function addGpsLocations(Transport $transport) {
		if (!empty($this -> gps)) {
			$locations = $transport -> getGpsNavigator() -> getLocationsArchive();
			foreach ($locations as $location) {
				$this -> gps -> addLocation($location);
			}
		} else {
			throw new InvalidOperationException("This Transport object hasn't GPSNavigator object to add Location. Set GPSNavigator object firstly");
		}
	}
	
	public function getGpsNavigator() : GPSNavigator {
		return $this -> gps;
	}
	
	public function getId() : int {
		return $this -> id;
	}
	
	public function getRoute() : string {
		return $this -> route;
	}
	
	public function getType() : int {
		return $this -> type;
	}
	
	public function setGpsNavigator(GPSNavigator $gps) {
		$this -> gps = $gps;
	}
	
}