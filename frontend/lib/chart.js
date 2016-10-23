var start_time = [];
var end_time = [];


function drawBasic() {
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'Время суток, ч');
  data.addColumn('number', 'Интервал, мин');

  for (var x = 0; x<start_time.length; x += 0) {
	  for (var y = 0; y<end_time.length; y++) {
		  if(start_time[x] < end_time[y]) {
				var interval = (end_time[y] - start_time[x]) / 60;
			  //alert(interval);
			  data.addRows([
				[new Date(start_time[x] * 1000).getHours(), interval]
			  ]);
			  x++;
			} else {
				x++; continue;
			}
		}
  }

  var options = {
	hAxis: {
	  title: 'Время суток, ч'
	},
	vAxis: {
	  title: 'Интервал, мин'
	},
	height: 1000
  };

  var chart1 = new google.visualization.Histogram(document.getElementById('chartHistogram'));
  var chart2 = new google.visualization.LineChart(document.getElementById('chartLine'))
	chart1.draw(data, options);
  chart2.draw(data, options);
}
