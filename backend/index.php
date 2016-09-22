<?php
	require_once "lib".DIRECTORY_SEPARATOR."data.php";
	define('DEFAULT_LAT_ERR', 0.00003);
	define('DEFAULT_LNG_ERR', 0.00004);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>#dataParser</title>		
	</head>
	<body>
		<h1>Data parser index.html</h1>
		<?php 
			$data = loadAllData("xxx.json");
			printData(filterData(
				$data,
				(int) $routeType,
				$data[0] -> t,
				$data[10] -> t,
				$data[0],
				$data[5],
				array ("lat" => DEFAULT_LAT_ERR, "lng" => DEFAULT_LNG_ERR)
				)
			);
			$pointA = $data[0];
			$pointA -> lat = 53.694051;
			$pointA -> lng = 23.825847;
			$pointB = $data[1];
			$pointB -> lat = 53.693727;
			$pointB -> lng = 23.827242;
			echo "<h3>Test distance(~100m): ";
			print(calculateDistance($pointA, $pointB));
			echo "</h3><hr/>";
		?>
	</body>
</html>