<?php

class DataModel extends StrictAccessClass {
	
	private $active = false;
	private $transport = array();
	private $gps = array();
	private $locations = array();
		
	public function getGps(int $index = -1) {
		if ($index === -1) {
			return $this -> gps;
		} else {
			return $this -> gps[$index];
		}
	}
	
	public function getLocations(int $index = -1) {
		if ($index === -1) {
			return $this -> locations;
		} else {
			return $this -> locations[$index];
		}
	}
	
	public function getTransport(int $index = -1) {
		if ($index === -1) {
			return $this -> transport;
		} else {
			return $this -> transport[$index];
		}
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