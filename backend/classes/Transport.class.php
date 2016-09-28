<?php

class Transport {
	
	private $gps;
	private $id = 0;
	private $route = ""; //n
	private $type = 0; //c
	
	public function __construct() {
		$gps = new GPSNavigator();
	}
	
	public function getGpsNavigator() {
		return $this -> gps;
	}
	
	public function getRoute() : string {
		return $this -> route;
	}
	
	public function getType() : int {
		return $this -> type;
	}
	
}