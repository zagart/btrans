<?php
	require_once "lib".DIRECTORY_SEPARATOR."data.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>#dataParser</title>		
	</head>
	<body>
		<h1>Data parser index.html</h1>
		<?php 
		/*
		{"n":"001","c":0,"id":354,"t":1471525492,"a":331,"s":0,"lat":53.64031,"lng":23.8642833},{"n":"001","c":0,"id":9,"t":1471525481,"a":333,"s":20,"lat":53.646875,"lng":23.8370333},{"n":"001","c":0,"id":50,"t":1471525479,"a":250,"s":18,"lat":53.6484367,"lng":23.8388233}
		*/
			$data = loadAllData("bus.json");
			printData(filterData(
				$data,
				(int) $routeType,
				1471525479,
				1471525492,
				$data[2],
				$data[0],
				array ("lat" => 0.1, "lng" => 0.1)
				)
			);
		?>
	</body>
</html>