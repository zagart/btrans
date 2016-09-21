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
			$data = loadAllData("bus.json");
			printArray(filterData((array) $data,
					(int) $routeType,
				   	(int) $lowTime,
				   	(int) $highTime,
				   	(array) $startPoint,
				   	(array) $endPoint,
				   	(int) $error));
			printArray($data); 	
		?>
	</body>
</html>