<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style/reset.min.css" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<title>SetJS</title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
	
		
	
	function getData() {
		$('#myForm').submit(function(e){
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				url: "http://btrans/backend/index.php",
				
				data: $(this).serialize(),
				success: function() {
					$.get("http://btrans/backend/data.json", success, "json");
				},
				error: function() {
					alert("Ошибка");
				}
			});
			function success(data) {
				var posts = [];
				$.each(data,function(key, val){
					posts.push('<p>'+val.gpsId+'</p>');
				});
				$('#msg').html(posts.join(''));
			}
			
		/*var date = document.getElementById("Radius").getAttribute("value");
		alert(date);*/
		});
	}
	</script>
</head>
<body>
<form method="post" id="myForm" action="" >
	<fieldset>
		<legend>Form Manager</legend>
		
			<div class="labelForm">
				<label>Latitude A</label><br>
				<label>longitude A</label><br>
				<label>Latitude B</label><br>
				<label>longitude B</label><br>
				<label>Radius</label><br>
				<label>MinTime</label><br>
				<label>MaxTime</label><br>
			</div>
			<div class="inputForm">
				<input class="ltta" type="text" name="latitudeA" value="53.69798" /><br>
				<input class="lgta" type="text" name="longitudeA" value="23.81959" /><br>
				<input class="lttb" type="text" name="latitudeB" value="53.69264" /><br>
				<input class="lgtb" type="text" name="longitudeB" value="23.8235" /><br>
				<input class="Radius" type="text" name="radius" value="20" /><br>
                
				<input id="minTime" type="datetime-local" name="minTime"><br>
				<input id="maxTime" type="datetime-local" name="maxTime"><br> 
				<input class="quantity" type="text" name="quantity"><br>  
				
			</div>
			<div class="clear"></div>
			<input class="sendData" type="submit" name="send" value="Send" onclick="javascript:getData()"/>
		
	</fieldset>
</form>
	<canvas id="chart" width="600" height="400"></canvas>
	<div id="msg"></div>
</body>
</html>