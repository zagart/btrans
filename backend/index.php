<?php
	require_once "lib".DIRECTORY_SEPARATOR."data.php";
	define('DEFAULT_LAT_ERR', 0.00002);
	define('DEFAULT_LNG_ERR', 0.00003);
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
				$data[4] -> t,
				$data[0],
				$data[4],
				array ("lat" => DEFAULT_LAT_ERR, "lng" => DEFAULT_LNG_ERR)
				)
			);
		?>
	</body>
</html>