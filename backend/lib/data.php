<?php
declare (strict_types = 1);

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
		if ($point -> t > $lowTime && $point -> t < $highTime) {
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
	$endPointTimeLimit = $startPoints[count($startPoints) - 1] -> t;
	for ($i = count($startPoints) - 1; $i > 0; $i--) {
		if ($startPoints[i] -> t >= $startPointTimeLimit) {
			unset($startPoints[i]);
		} else {
			break;
		}
	}
	for ($i = count($endPoints) - 1; $i > 0; $i--) {
		if ($endPoints[i] -> t <= $endPointTimeLimit) {
			unset($endPoints[i]);
		} else {
			break;
		}
	}
	$i = 0;
	while ($i < count($endPoints) - 1 && $i < count($startPoints) - 1) {
		echo "startPoint: <br/>";
		printArray($startPoints[$i]);
		echo "endPoint: <br/>";
		printArray($endPoints[$i]);
		echo "<hr/>";
		$directions[] = array(
			$startPoints[$i], 
			$endPoints[$i]
		);
		$i++;
	}
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
	echo "<pre>";
	foreach ($data as $array) {
		print_r($array);
		$time = $array[1] -> t - $array[0] -> t;
		echo "<br/>Interval: $time<hr/><br/>";
	}
	echo "</pre>";
}

?>