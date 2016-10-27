<?php
	error_reporting(E_ALL);
	define("SOURCE_FILE_PATH", "ALL_routes_28h.json");
	require_once "lib".DIRECTORY_SEPARATOR."autoloader.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."common.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."data.inc.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>#dataParser</title>
	</head>
	<body>
		<h1>Data parser index.php</h1>
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$latA = $_POST["latitudeA"];
			$lngA = $_POST["longitudeA"];
			$latB = $_POST["latitudeB"];
			$lngB = $_POST["longitudeB"];
			$radius = $_POST["radius"];
			$minTime = $_POST["minTime"];
			$maxTime = $_POST["maxTime"];
			$directions = getDirectionsByParameters(
								SOURCE_FILE_PATH,
								new IdAlgorithm(),
								$latA,
								$lngA,
								$latB,
								$lngB,
								$radius,
								$minTime,
								$maxTime
			);
			debug($directions);
			$json_directions_file = json_encode($directions);
			file_put_contents("data.json", $json_directions_file);
		}
		?>
	</body>
</html>
