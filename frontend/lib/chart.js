var start_time = [];
var end_time = [];
	
	
function drawBasic() {
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'X');
  data.addColumn('number', 'Минуты');
  
  for (var x = 0; x<start_time.length; x++) {
	  for (var y = 0; y<end_time.length; y++) {
		  //start_time[x] = new Date(start_time[x] * 1000);
		  //end_time[y] = new Date(end_time[y] * 1000);
		  var interval = (end_time[y] - start_time[x]) / 60;
		  //alert(interval);
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