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
	}
	
	</script>
</head>
<body>
<form method="post" id="myForm" action="" >
	<fieldset>
		<legend>Форма диспетчера</legend>
		
			<div class="labelForm">
				<label>Остановка 1</label><br>
				<label>Остановка 2</label><br>
				<label>Радиус</label><br>
				<label>Время старта</label><br>
				<label>Время интервала</label><br>
			</div>
			<div class="inputForm">
				<input class="Dolgota" type="text" name="Dolgota" /><br>
				<input class="Shirota" type="text" name="Shirota" /><br>
				<input class="Radius" type="text" name="Radius" /><br>
<!--			<input type="datetime-local" name="StartTime"><br>
				<input type="datetime-local" name="WayTime"><br> 		-->
			</div>
			<div class="clear"></div>
			<input class="sendData" type="submit" name="send" value="Отправить" onclick="javascript:getData()"/>
		
	</fieldset>
</form>
	<div id="msg"></div>
</body>
</html>