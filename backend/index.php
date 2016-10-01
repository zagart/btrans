<?php
	error_reporting(E_ALL);
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
<!--
		<?php 
			$core = new Core();
			$core -> loadData("ALL_routes_28h.json");
			$data = $core -> getData();
			$core -> convertData();
			
			$startIndex = 2;
			$endIndex = 22;
		
			$startLocation = new Location(53.6859983, 23.8474583);
			$endLocation = new Location(53.6449033, 23.8558033);
			$radius = 10;
			$startObject = new MapRound($startLocation, $radius);
			$endObject = new MapRound($endLocation, $radius);
		
			$core -> setUpInitialData(
				$startObject, 
				$endObject, 
				Core::OBJECT_TYPE_ROUND
			);
			$core -> process(
				new IdAlgorithm(),
				new TimeLimiter(1475240000, 1475248461)
			);
		?>
-->
	</body>
</html>