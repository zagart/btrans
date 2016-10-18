<?php

function printObject($object) {
	echo "<pre><h4>";
	print_r($object);
	echo "</h4></pre>";
}

function debug($object) {
	echo "<pre><h4>";
	print_r($object);
	echo "</h4></pre>";
}


function printRandomDirections(int $quantity) {
	for ($i = 0; $i < $quantity; $i++) {
		printObject(json_encode((new RandomDirection()) -> toArray()));	
	}
}

function printRealDirections(
	string $filePath,
	Algorithm $algorithm, 
	float $latA, 
	float $lngA,	
	float $latB, 
	float $lngB,
	int $radius,
	int $minTime,
	int $maxTime,
	bool $jsonFormat
) {
	$core = new Core();
	$time = time();
	echo "<hr/><h2>Core created.</h2><br/>";
	$core -> loadData($filePath);
	$current = time() - $time;
	$size = sizeof($core -> getData());
	echo "<h2>Core loaded $size elements at $current sec.</h2><br/>";
	$core -> convertData();
	$current = time() - $time;
	echo "<h2>Core converted all data to model at $current sec.</h2><br/>";
	$startLocation = new Location($latA, $lngA);
	$endLocation = new Location($latB, $lngB);
	$startObject = new MapRound($startLocation, $radius);
	$endObject = new MapRound($endLocation, $radius);
	$core -> setUpInitialData(
		$startObject, 
		$endObject, 
		Core::OBJECT_TYPE_ROUND
	);
	$current = time() - $time;
	echo "<h2>Core configured at $current sec.</h2><br/>";
	$core -> process(
		$algorithm,
		new TimeLimiter($minTime, $maxTime)
	);
	$current = time() - $time;
	echo "<h2>Core processed algorithm at $current sec.</h2><br/>";
	if (empty($core -> getDirections())) {
		echo "<h2>Directions not found.</h2><hr/>";
	} else {
		$size = sizeof($core -> getDirections());
		echo "<h2>$size direction(s) generated.</h2><hr/>";
	}
	$directionArr = $core -> getDirections();
	usort($directionArr, function ($a, $b) {
		$startTime = $a -> getEndLocation() -> getTimestamp() - $a -> getStartLocation() -> getTimestamp();
		$endTime = $b -> getEndLocation() -> getTimestamp() - $b -> getStartLocation() -> getTimestamp();
		if ($startTime < $endTime) {
			return -1;
		} else if ($startTime > $endTime) {
			return 1;
		} else {
			return 0;
		}
	});
	foreach ($directionArr as $direction) {
		if ($jsonFormat) {
			array_push($directionArr, $direction -> toArray());
		} else {
			printObject($direction -> toArray());
			$interval = $direction -> getEndLocation() -> getTimestamp() - $direction -> getStartLocation() -> getTimestamp();
			echo "<h4>Interval: $interval sec.</h4><hr/>";
		}
	}
	return $directionArr;
}