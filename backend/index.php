<?php
	error_reporting(E_ALL);
	define("SOURCE_FILE_PATH", "ALL_routes_73h.json");
	require_once "lib".DIRECTORY_SEPARATOR."autoloader.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."common.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."data.inc.php";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		printRandomDirections((int) $_POST["quantity"]);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>#dataParser</title>		
	</head>
	<body>
		<h1>Data parser index.php</h1>
		<?php 
		$latA = 53.69798;
		$lngA = 23.81959;
		$latB = 53.69264;
		$lngB = 23.8235;
		$radius = 30;
		$minTime = 0;
		$maxTime = time();
		$jsonFormat = true;
		printRealDirections(SOURCE_FILE_PATH, 
							$latA, 
							$lngA,	
							$latB, 
							$lngB,
							$radius,
							$minTime,
							$maxTime,
							$jsonFormat
		);
		?>
	</body>
</html>