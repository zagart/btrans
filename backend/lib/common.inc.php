<?php

function printObject($object) {
	echo "<pre><h4>";
	print_r($object);
	echo "</h4></pre>";
}

function debug($object, $tag = "Debug") {
	echo "<hr/><h3>$tag</h3><pre><h4>";
	print_r($object);
	echo "</h4></pre>";
}

function printRandomDirections(int $quantity) {
	for ($i = 0; $i < $quantity; $i++) {
		printObject(json_encode((new RandomDirection()) -> toArray()));
	}
}

function getDirectionsByParameters(
	string $filePath,
	Algorithm $algorithm,
	float $latA,
	float $lngA,
	float $latB,
	float $lngB,
	int $radius,
	int $minTime,
	int $maxTime
) : array {
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
	$directions = $core -> getDirections();
	if (empty($directions)) {
		echo "<h2>Directions not found.</h2><hr/>";
	} else {
		$size = sizeof($directions);
		echo "<h2>$size direction(s) generated.</h2><hr/>"	;
	}
	$condition = true;
	foreach ($directions as &$direction) {
		if ($condition) {
			//		$id = $direction -> getId();
			$route = $direction -> getTransportRoute();
			$interval = $direction -> getInterval();
			$time = $direction -> getStartTime() - 1475149361;
			echo "$route: $time ($interval sec)<br/>";
			$direction = $direction -> toArray();			
		}
	}
	return $directions;
}
