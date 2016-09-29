<?php

class DataModel extends StrictAccessClass {
	
	private $active = false;
	private $transport = array();
	private $gps = array();
	private $locations = array();
		
	public function getGps() : array {
		return $this -> gps;
	}
	
	public function getLocations() : array {
		return $this -> locations;
	}
	
	public function getTransport() : array {
		return $this -> transport;
	}
	
	public function isActive() : bool {
		return $this -> active;
	}
	
	public function parseData(array $data) {
		$this -> active = true;
		foreach ($data as $record) {
			$this -> transport[] = new Transport($record -> n, $record -> c);
			$this -> gps[] = new GPSNavigator($record -> id);
			$this -> locations[] = new Location(
				$record -> lat,
				$record -> lng,
				$record -> t,
				$record -> a,
				$record -> s
			);
		}
	}
	
	public function printModel() {
		for ($i = 0; $i < sizeof($this -> gps); $i++) {
			echo "<hr/>";
			echo "
			Маршрут: {$this -> transport[$i] -> getRoute()}<br/>
			Тип маршрута: {$this -> transport[$i] -> getType()} <br/>
			GPS: {$this -> gps[$i] -> getId()} <br/>
			Широта: {$this -> locations[$i] -> getLatitude()} <br/>
			Долгота: {$this -> locations[$i] -> getLongitude()} <br/>
			Азимут: {$this -> locations[$i] -> getAzimuth()} <br/>
			Скорость: {$this -> locations[$i] -> getSpeed()} <br/>
			";
		}
	}
	
}