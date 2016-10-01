<?php

class Location extends StrictAccessClass {
	
	private $azimuth = 0; //a
	private $id = 0;
	private $lat = 0; //lat
	private $lng = 0; //lng
	private $timestamp = 0; //t
	private $speed = 0; //s
	
	public function __construct(float $lat, 
								float $lng, 
								int $timestamp = 0, 
								int $azimuth = 0,
							   	int $speed = 0) {
		$this -> lat = $lat;
		$this -> lng = $lng;
		$this -> timestamp = $timestamp;
		$this -> azimuth = $azimuth;
		$this -> speed = $speed;
	}

	public function __toString() : string {
		return "<hr/>
		<h1>Point method toString() processed:<br/></h1>
		<h2>Latitude: {$this -> lat}<br/>
		Longitude: {$this -> lng}<br/>
		Timestamp: {$this -> timestamp}
		</h2><hr/>";
	}
	
	public static function compareByTime($a, $b) : int {
		if ($a -> getTimestamp() == $b -> getTimestamp()) {
			return 0;
		} else if ($a -> getTimestamp() > $b -> getTimestamp()) {
			return 1;
		} else {
			return -1;
		}
	}
	
	public function distanceTo(Location $location) : int {
		$latA=deg2rad($this -> lat); 
        $lngA=deg2rad($this -> lng); 
        $latB=deg2rad($location -> getLatitude()); 
        $lngB=deg2rad($location -> getLongitude()); 
        $delta_lat=($latB - $latA); 
        $delta_lng=($lngB - $lngA); 
        return 6378137 * acos(cos($latA) * cos($latB) * cos($lngA - $lngB) + sin( $latA) * sin($latB));
	}
	
	public function getAzimuth() : int {
		return $this -> azimuth;
	}
	
	public function getId() : int {
		return $this -> id;
	}
	
	public function getLatitude() : float {
		return $this -> lat;
	}
	
	public function getLongitude() : float {
		return $this -> lng;
	}
		
	public function getSpeed() : int {
		return $this -> speed;
	}
	
	public function getTimestamp() : int {
		return $this -> timestamp;
	}
	
	public function timeTo(Location $location) : int {
		return abs($this -> timestamp - $location -> getTimestamp());
	}
	
	public function toArray() {
		return array(
			"azimuth" => $this -> azimuth,
			"id" => $this -> id,
			"lat" => $this -> lat,
			"lng" => $this -> lng,
			"timestamp" => $this -> timestamp,
			"speed" => $this -> speed
		);
	}
	
	public static function splitLocationsByDelayTime(array &$locations, int $delayTime) : array {
		usort($locations, array("Location", "compareByTime"));
		$result = array();
		while (sizeof($locations) > 0) {
			$archive = array();
			$startLocation = clone $locations[0];
			for ($i = 0; $i < sizeof($locations); $i++) {
				if ($startLocation -> timeTo($locations[$i]) <= $delayTime) {
					$time = $startLocation -> timeTo($locations[$i]);
					$archive[] = $locations[$i];
					unset($locations[$i]);
					$locations = array_values($locations);
					$i--;
				}
			}
			$result[] = $archive;
		}
		return $result;
	}
	

}