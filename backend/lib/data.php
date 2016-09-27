<?php
declare (strict_types = 1);

function calculateDistance($pointA, $pointB) : float {
        $latA=deg2rad($pointA -> lat); 
        $lngA=deg2rad($pointA -> lng); 
        $latB=deg2rad($pointB -> lat); 
        $lngB=deg2rad($pointB -> lng); 
        $delta_lat=($latB - $latA); 
        $delta_lng=($lngB - $lngA); 
        return 6378137 * acos(cos($latA) * cos($latB) * cos($lngA - $lngB) + sin( $latA) * sin($latB));
}

function compareByTime($a, $b) : int {
    if ($a -> t == $b -> t)
    {
//        echo "a ({$a -> t}) is same priority as b ({$b -> t}), keeping the same<hr/>";
        return 0;
    }
    else if ($a -> t > $b -> t)
    {
//        echo "a ({$a -> t}) is higher priority than b ({$b -> t}), moving b down array<hr/>";
        return 1;
    }
    else {
//        echo "b ({$b -> t}) is higher priority than a ({$a -> t}), moving b up array<hr/>";                
        return -1;
    }
}

function filterData(
	array $data, 		
	int $routeType,		   	
	int $lowTime,		   	
	int $highTime,			   	
	$startPoint,			   	
	$endPoint,			   
	array $error) : array 
{
	$startPoints = getApproximatePoints(
		$data,
		$startPoint, 
		$lowTime, 
		$highTime, 
		$error
	);
	$endPoints = getApproximatePoints(
		$data, 
		$endPoint, 
		$lowTime, 
		$highTime, 
		$error
	);
	return generateDirections($startPoints, $endPoints);
}

function getApproximatePoints(
	array $data,
	$fixedPoint,
	int $lowTime,
	int $highTime,
	array $error) : array 
{	
	$selectedPoints = array();
	foreach ($data as $point) {
		if ($point -> t >= $lowTime && $point -> t < $highTime) {
			if (isSoughtPoint($point, $fixedPoint, $error)) {	
				$selectedPoints[] = $point;
			} 
		}
	}
	return $selectedPoints;
}

function generateDirections(array $startPoints, array $endPoints) : array {
	$directions = array();
	usort($startPoints, "compareByTime");
	usort($endPoints, "compareByTime");
	$startPointTimeLimit = $endPoints[0] -> t;
	while ($point = each($startPoints)) {
		if ($point[1] -> t > $startPointTimeLimit) {
			$startPoints = array_slice($startPoints, 0, $point[0]);
			break;
		}
	}
	$endPointTimeLimit = $startPoints[count($startPoints) - 1] -> t;
	end($endPoints);
	while (!is_null($index = key($endPoints))) {
		$point = current($endPoints);
		if ($point -> t <= $endPointTimeLimit) {
			$endPoints = array_slice($endPoints, $index + 1, sizeof($endPoints) - 1);
			break;
		}
		prev($endPoints);
	}
	echo "<hr/>Start limit: $startPointTimeLimit</br>";
	echo "End limit: $endPointTimeLimit<hr/>";
	$i = 0;
	while ($i < count($endPoints) && $i < count($startPoints)) {
		$directions[] = array(
			$startPoints[$i], 
			$endPoints[$i]
		);
		$i++;
	}
	echo "Start sorted points:<br/>";
	printPointsTime($startPoints);
	echo "End sorted points:<br/>";
	printPointsTime($endPoints);
	echo "<hr/>";
	return $directions;
}

function isSoughtPoint($point, $fixedPoint, array $error) : bool {
	if (
		(
			$fixedPoint -> lat + (float) $error['lat'] >= $point -> lat && 
			$fixedPoint -> lng + (float) $error['lng'] >= $point -> lng
		) and (
			$fixedPoint -> lat - (float) $error['lat'] <= $point -> lat &&
			$fixedPoint -> lng - (float) $error['lng'] <= $point -> lng
		)	
	) {
		return true;
	} 
//	
//	$latP = $fixedPoint -> lat + (float) $error['lat'];
//	$lat = $point -> lat;
//	$latM = $fixedPoint -> lat - (float) $error['lat'];
//	
//	$lngP = $fixedPoint -> lng + (float) $error['lng'];
//	$lng = $point -> lng;
//	$lngM = $fixedPoint -> lng - (float) $error['lng'];	
//	
//	echo "Lat: <br/>{$latM}<br/>{$lat}<br/>{$latP}<br/>";	
//	echo "Lng: <br/>{$lngM}<br/>{$lng}<br/>{$lngP}<hr/>";
	return false;
}

function loadAllData(string $fileName) : array {
	$file = file_get_contents("resources".DIRECTORY_SEPARATOR.$fileName);
	if ($file) {
			return json_decode($file);
	} else {
			return array();
	}
}

function printArray($array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function printData($data) {
	echo "<h1>Generated direction.</h1><pre>";
	foreach ($data as $array) {
		print_r($array);
		$time = $array[1] -> t - $array[0] -> t;
		$distance = round(calculateDistance($array[0], $array[1]));
		echo "<h2>Interval: $time sec</h2>";
		echo "<h2>Distance: $distance m</h2>";
		echo "<hr/>";
	}
	echo "</pre>";
}

function printPointsTime($points) {
	foreach ($points as $point) {
		echo "{$point -> t}<br/>";
	}
}

function randomDirection() {
	
}

?>