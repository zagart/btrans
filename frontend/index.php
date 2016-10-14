<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style/reset.min.css" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<title>SetJS</title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	
		
		var start_time = [];
		var end_time = [];
	
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
		});
	}
	function success(data) {
		
		$.each(data,function(key, val){
			start_time.push(val.startLocation.timestamp);
			end_time.push(val.endLocation.timestamp);
			
		});
		google.charts.load('current', {packages: ['corechart', 'line']});
		google.charts.setOnLoadCallback(drawBasic);
		//$('#msg').html(end_time.join('<br>'));
		//$('#msg').html(data);
	}
	function drawBasic() {
	  var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'Минуты');
	  
	  for (var x = 0; x<start_time.length; x++) {
		  for (var y = 0; y<end_time.length; y++) {
			  //start_time[x] = new Date(start_time[x] * 1000);
			  //end_time[y] = new Date(end_time[y] * 1000);
			  var interval = (end_time[y] - start_time[x]) / 60;
			  alert(interval);
			  data.addRows([
				[new Date(start_time[x] * 1000).getHours(), interval]
			  ]);
			  x++;
		  }
	  }
     
      var options = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Popularity'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart'));

      chart.draw(data, options);
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
	<div id="chart"></div>
</body>
</html>