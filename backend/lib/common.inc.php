<?php

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
	bool $debugPrint
) {
	$core = new Core();
	$time = time();
	Logger::log("<hr/><h2>Core created.</h2><br/>");
	$core -> loadData($filePath);
	$current = time() - $time;
	$size = sizeof($core -> getData());
	Logger::log("<h2>Core loaded $size elements at $current sec.</h2><br/>");;
	$core -> convertData();
	$current = time() - $time;
	Logger::log("<h2>Core converted all data to model at $current sec.</h2><br/>");;
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
	Logger::log("<h2>Core configured at $current sec.</h2><br/>");;
	$core -> process(
		$algorithm,
		new TimeLimiter($minTime, $maxTime)
	);
	$current = time() - $time;
	Logger::log("<h2>Core processed algorithm at $current sec.</h2><br/>");
	if (empty($core -> getDirections())) {
		Logger::log("<h2>Directions not found.</h2><hr/>");
	} else {
		$size = sizeof($core -> getDirections());
		Logger::log("<h2>$size direction(s) generated.</h2><hr/>");
	}
	$directions = $core -> getDirections();
	usort($directions, function ($a, $b) {
		$startTime = $a -> getStartLocation() -> getTimestamp();
		$endTime = $b -> getStartLocation() -> getTimestamp();
		if ($startTime < $endTime) {
			return -1;
		} else if ($startTime > $endTime) {
			return 1;
		} else {
			return 0;
		}
	});
	$directionsArr = array();
	foreach ($directions as $direction) {
		$directionsArr[] = $direction -> toArray();
	}
	if ($debugPrint) {
		//TODO debug logic
		foreach ($directions as $direction) {
			$startTime = $direction -> getStartTime() - 1475149361;
			$interval = $direction -> getInterval();
			Logger::log("Interval: $interval; Start time: $startTime </br>");
		}
		Logger::print();
	}
	return $directionsArr;
}
