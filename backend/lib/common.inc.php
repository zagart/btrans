<?php

function printObject($object) {
	echo "<pre><h4>";
	print_r($object);
	echo "</h4></pre>";
}


function printRandomDirections(int $quantity) {
	for ($i = 0; $i < $quantity; $i++) {
		$startTime = 1475171600 + rand(-1, 99);
		$endTime = $startTime + rand(19, 60);
		$startLocation = new Location(
			(float) rand(39, 70) + rand(-1, 9)/10,
			(float) rand(39, 70) + rand(-1, 9)/10,
			$startTime,
			rand(-1, 360),
			rand(-1, 40)
		);
		$endLocation = new Location(
			(float) rand(39, 70) + rand(-1, 9)/10,
			(float) rand(39, 70) + rand(-1, 9)/10,
			$endTime,
			rand(-1, 360),
			rand(-1, 40)
		);
		printObject((new Direction($startLocation,
							   $endLocation,
							   rand(1, 100),
							   (string) rand(1, 50),
							   rand(0, 3)
							  )) -> toArray());	
	}
}