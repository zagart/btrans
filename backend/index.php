<?php
	require_once "lib".DIRECTORY_SEPARATOR."autoloader.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."common.inc.php";
	require_once "lib".DIRECTORY_SEPARATOR."data.inc.php";
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
			//Change for commit.
			$location = new Location(0.1, 2.2, 1932041924);
			$gps = new GPSNavigator();
			$gps -> addLocation($location);
		?>
	</body>
</html>