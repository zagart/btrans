<?php

class RandomDirection extends Direction {
	
	public function __construct() {
		$startTime = 1475171600 + rand(-1, 99);
		$endTime = $startTime + rand(19, 60);
		$this -> startLocation = new Location(
			(float) rand(39, 70) + rand(-1, 9)/10,
			(float) rand(39, 70) + rand(-1, 9)/10,
			$startTime,
			rand(-1, 360),
			rand(-1, 40)
		);
		$this -> endLocation = new Location(
			(float) rand(39, 70) + rand(-1, 9)/10,
			(float) rand(39, 70) + rand(-1, 9)/10,
			$endTime,
			rand(-1, 360),
			rand(-1, 40)
		);
		$this -> gpsId = rand(1, 100);
		$this -> transportRoute = (string) rand(1, 50);
		$this -> transportType = rand(0, 3);
		self::$counter++;
		$this -> id = self::$counter;
	}
	
}