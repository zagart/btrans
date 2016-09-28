<?php

class Point {
	private $lat = 0; //id
	private $lng = 0; //c
	
	public function __construct(float $lat, float $lng) {
		$this -> lat = $lat;
		$this -> lng = $lng;
	}
	
	public function getLat() : float {
		return $this -> lat;
	}
	
	public function getLng() : float {
		return $this -> lng;
	}
	
	public function __destruct() {
		//act on destruct
	}
}