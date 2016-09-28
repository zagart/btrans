<?php

class Location extends StrictAccessClass {
	
	private $azimuth = 0; //a
	private $id = 0;
	private $lat = 0; //lat
	private $lng = 0; //lng
	private $timestamp = 0; //t
	
	public function __construct(float $lat, 
								float $lng, 
								int $timestamp, 
								int $azimuth = 0) {
		$this -> lat = $lat;
		$this -> lng = $lng;
		$this -> timestamp = $timestamp;
		$this -> azimuth = $azimuth;
	}

	public function __toString() : string {
		return "<hr/>
		<h1>Point method toString() processed:<br/></h1>
		<h2>Latitude: {$this -> lat}<br/>
		Longitude: {$this -> lng}<br/>
		Timestamp: {$this -> timestamp}
		</h2><hr/>";
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
	
	public function getTimestamp() : int {
		return $this -> timestamp;
	}

}