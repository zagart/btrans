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
		<h1>Data parser index.html</h1>
		
<!-- Commit for rebase.
		<?php 
			$startLocation = new Location(50.1, 60.1, 10000);
			$endLocation = new Location(50.2, 60.2, 11000);
			$radius = 2;
			$startObject = new MapRound($startLocation, $radius);
			$endObject = new MapRound($endLocation, $radius);
			$core = new Core();
			$core -> loadData("ALL_routes.json");
			$core -> convertData();
			$core -> setUpInitialData(
				$startObject, 
				$endObject, 
				Core::OBJECT_TYPE_ROUND
			);
			$core -> process(new IdAlgorithm());
			$core -> getDirections();
		?>
-->
	</body>
</html>