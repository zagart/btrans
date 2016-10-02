<?php

class Direction extends StrictAccessClass {
	
	protected static $counter = 0;
	
	protected $id = 0;
	protected $transportRoute = "";
	protected $transportType = 0;
	protected $gpsId = 0;
	protected $startLocation = null;
	protected $endLocation = null;
	
	public function __construct(Transport $startCopy, Transport $endCopy) {
		$this -> startLocation = $startCopy -> getGpsNavigator() -> getAverageLocation();
		$this -> endLocation = $endCopy -> getGpsNavigator() -> getAverageLocation();
		$this -> gpsId = $startCopy -> getGpsNavigator();
		$this -> transportRoute = $startCopy -> getRoute()."/".$endCopy -> getRoute();
		$this -> transportType = $startCopy -> getType();
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
			"gpsId" => $this -> gpsId -> getId(),
			"startLocation" => $this -> startLocation -> toArray(),
			"endLocation" => $this -> endLocation -> toArray()
		);
	}
	
}