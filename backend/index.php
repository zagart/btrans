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
//			$baseTime = 1475200000;
//			$core = new Core();
//			$time = time();
//			echo "<hr/><h2>Core created.</h2><br/>";
//			$core -> loadData(SOURCE_FILE_PATH);
//			$current = time() - $time;
//			$size = sizeof($core -> getData());
//			echo "<h2>Core loaded $size elements at $current sec.</h2><br/>";
//			$core -> convertData();
//			$current = time() - $time;
//			echo "<h2>Core converted all data to model at $current sec.</h2><br/>";
//			$startLocation = new Location(53.69798, 23.81959);
//			$endLocation = new Location(53.69264, 23.8235);
//			$radius = 10;
//			$startObject = new MapRound($startLocation, $radius);
//			$endObject = new MapRound($endLocation, $radius);
//			$core -> setUpInitialData(
//				$startObject, 
//				$endObject, 
//				Core::OBJECT_TYPE_ROUND
//			);
//			$current = time() - $time;
//			echo "<h2>Core configured at $current sec.</h2><br/>";
//			$core -> process(
//				new IdAlgorithm(),
//				new TimeLimiter($baseTime, $baseTime + TimeLimiter::DAY)
//			);
//			$current = time() - $time;
//			echo "<h2>Core processed alrorithm at $current sec.</h2><br/>";
//			if (empty($core -> getDirections())) {
//				echo "<h2>Directions not found.</h2><hr/>";
//			} else {
//				$size = sizeof($core -> getDirections());
//				echo "<h2>$size direction(s) generated.</h2><hr/>";
//			}
//			foreach ($core -> getDirections() as $direction) {
//				printObject($direction -> toArray());
//			}
		?>
	</body>
</html>