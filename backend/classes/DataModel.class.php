<?php

class DataModel extends StrictAccessClass {
	
	private $transport;
	private $gps;
	private $locations;
		
	/*{
	"n":"001",
	"c":0,
	"id":50,
	"t":1475148789,
	"a":54,
	"s":0,
	"lat":53.64017,
	"lng":23.8647733}
	*/
	public function parseData(array $data) {
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