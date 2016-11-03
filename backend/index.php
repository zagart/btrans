<?php
	error_reporting(E_ALL);
	define("SOURCE_FILE_PATH", "ALL_routes_28h.json");
	require_once "lib".DIRECTORY_SEPARATOR."autoloader.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."common.inc.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>#dataParser</title>		
	</head>
	<body>
		<?php 
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$latA = $_POST["latitudeA"];
			$lngA = $_POST["longitudeA"];
			$latB = $_POST["latitudeB"];
			$lngB = $_POST["longitudeB"];
			$radius = $_POST["radius"];
			$minTime = $_POST["minTime"];
			$maxTime = $_POST["maxTime"];
			$algorithm = $_POST["algorithm"];
			if ($algorithm == "id") {
				$algorithm = new IdAlgorithm();
			} else if ($algorithm == "route") {
				$algorithm = new RouteAlgorithm();
			}
			$debugPrint = false;
			$json_result = json_encode(printRealDirections(SOURCE_FILE_PATH, 
								$algorithm,
								$latA, 
								$lngA,	
								$latB, 
								$lngB,
								$radius,
								$minTime,
								$maxTime,
								$debugPrint
			));
			echo $json_result;
		}
		?>
	</body>
</html>