<?php

class Direction extends StrictAccessClass {
	
	private static $counter = 0;
	
	private $id = 0;
	private $transportRoute = "";
	private $transportType = 0;
	private $gpsId = 0;
	private $startLocation = null;
	private $endLocation = null;
	
	public function __construct(Location $startLocation, 
								Location $endLocation,
							   	int $gpsId = 0,
							   	string $transportRoute = "",
							   	int $transportType = 0) {
		$this -> startLocation = $startLocation;
		$this -> endLocation = $endLocation;	
		$this -> gpsId = $gpsId;
		$this -> transportRoute = $transportRoute;
		$this -> transportType = $transportType;
		self::$counter++;
		$this -> id = self::$counter;
	}
	
	public function getEndLocation() : Location {
		return $this -> endLocation;
	}
	
	public function getGpsId() {
		return $this -> gpsId;
	} 
	
	public function getId() : int {
		return $this -> id;
	}
	
	public function getStartLocation() : Location {
		return $this -> startLocation;
	}
	
	public function getTransportRoute() : string {
		return $this -> transportRoute;
	}
	
	public function getTransportType() : int {
		return $this -> transportType;
	}
	
	public function toArray() {
		return array(
			"directionId" => $this -> id,
			"transportRoute" => $this -> transportRoute,
			"transportType" => $this -> transportType,
			"gpsId" => $this -> gpsId,
			"startLocation" => $this -> startLocation -> toArray(),
			"endLocation" => $this -> endLocation -> toArray()
		);
	}
	
}