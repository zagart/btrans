<?php
declare (strict_types = 1);

/*	$data array format required:

            [n] => 001
            [c] => 0
            [id] => 354
            [t] => 1471525492
            [a] => 331
            [s] => 0
            [lat] => 53.64031
            [lng] => 23.8642833
			
*/
function filterData(array $data,
					array $fixedPoints,
					int $routeType,
				   	int $lowTime,
				   	int $highTime,
				   	array $startPoint,
				   	array $endPoint,
				   	int $error) : array {
	$sections = array();
	for($i = 0; i < count($fixedPoints) - 2;) {
		$counter = 0;
		$startPoint = $fixedPoints[$i];
		$endPoint = $fixedPoints[++$i];
		$startPoints = getStartPoints($data,
								  $startPoint, 
								  $lowTime, 
								  $highTime, 
								  $error);
		$endPoints = getEndPoints($data, 
							  $endPoint, 
							  $lowTime, 
							  $highTime, 
							  $error);
		$sections[$counter++] = generateAllSections($startPoints, 
													$endPoints, 
													$routeType);
	}
	return generateDirections($sections);
}

function getStartPoints(array $data,
					array $startPoint,
				   	int $lowTime,
				   	int $highTime,
				   	int $error) : array {
	return array();
}

function getEndPoints(array $data,
					array $endPoint,
				   	int $lowTime,
				   	int $highTime,
				   	int $error) : array {
	return array();
}

function generateAllSections(array $startPoints, 
							array $endPoints, 
							int $routeType) : array {
	return array();
}

function generateDirections(array $sections, array $fixedPoints) {
	return array();
}


function loadAllData(string $fileName) : array {
	$file = file_get_contents("resources".DIRECTORY_SEPARATOR.$fileName);
	if ($file) {
			return json_decode($file);
	} else {
			return array();
	}
}

function printArray(array $array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

?>