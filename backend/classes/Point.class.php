<?php

require_once "exceptions".DIRECTORY_SEPARATOR."AccessDeniedException.class.php";

class Point {
	private $lat = 0; //lat
	private $lng = 0; //lng
	
	public function __construct(float $lat, float $lng) {
		$this -> lat = $lat;
		$this -> lng = $lng;
	}
	
	public function __get(string $name) {
		throw new AccessDeniedException("Getting of properties is available only threw direct getters!");
	}
	
	public function __set(string $name, $value) {
		throw new AccessDeniedException("Setting of properties is available only threw direct setters!");
	}
	
	public function __toString() : string {
		return "<hr/>
		<h1>Point method toString() processed:<br/></h1>
		<h2>Latitude: {$this -> lat}<br/>
		Longitude: {$this -> lng}
		</h2><hr/>";
	}
	
	public function getLat() : float {
		return $this -> lat;
	}
	
	public function getLng() : float {
		return $this -> lng;
	}

}