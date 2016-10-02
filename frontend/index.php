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
				dataType: "html",
				data: $(this).serialize(),
				success: function(html) {
					$("#msg").html(html);
					
				}
			});
			
		});	
		/*var date = document.getElementById("minTime").getAttribute("value");
		alert(date);*/
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
				<input class="ltta" type="text" name="latitudeA" /><br>
				<input class="lgta" type="text" name="longitudeA" /><br>
				<input class="lttb" type="text" name="latitudeB" /><br>
				<input class="lgtb" type="text" name="longitudeB" /><br>
				<input class="Radius" type="text" name="radius" /><br>
				<input id="minTime" type="datetime-local" name="minTime"><br>
				<input id="maxTime" type="datetime-local" name="maxTime"><br> 
	<!--		<input class="quantity" type="text" name="quantity"><br>  -->
				
			</div>
			<div class="clear"></div>
			<input class="sendData" type="submit" name="send" value="Send" onclick="javascript:getData()"/>
		
	</fieldset>
</form>
	<div id="msg"></div>
</body>
</html>