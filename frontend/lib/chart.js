function drawBasic() {
  var data = new google.visualization.DataTable();
  var time;
  var interval;
  var transportType = [];
  var transportRoute = [];
  var directionStartTime = [];
  var directionInterval = [];

  data.addColumn('timeofday', 'startTime');
  data.addColumn('number', 'interval');

  $.each(dataJSON, function(key, val) {
    time = new Date(val.startTime * 1000);
    interval = val.interval / 60;
    if(val.directionId && interval < 4) {
      transportRoute.push(val.transportRoute);
      transportType.push(val.transportType);
      directionStartTime.push(time.getHours()+":"+time.getMinutes()+":"+time.getSeconds());
      directionInterval.push(Math.floor(interval) + " мин " + val.interval % 60 + " сек");
      data.addRows([
        [{v:[time.getHours(), time.getMinutes(), time.getSeconds()], f:time.getHours()+":"+time.getMinutes()+":"+time.getSeconds()}, interval]
      ]);
    }
  });
  var options = {
    title:'График',
    width:510,
    height:400,
    bar: {
      groupWidth:"97%"
    },
    hAxis: {
      title:'Time Of Day',

      viewWindow: {
        min: [0,00,0],
        max: [24,00,0]
      }
    },

  }
  var chart = new google.visualization.ColumnChart(document.getElementById('chartHistogram'));
  google.visualization.events.addListener(chart, 'select', selectHundler);

  function selectHundler() {
    var selectedItem = chart.getSelection() [0];
    if(selectedItem) {
      $('<tr>' +
          '<td>'+ transportType[selectedItem.row] + '</td>' +
          '<td>' + transportRoute[selectedItem.row] + '</td>'+
          '<td>' + directionStartTime[selectedItem.row] + '</td>'+
          '<td>' + directionInterval[selectedItem.row] + '</td>' +
        '</tr>').appendTo('#directionInf');

      //alert("directionId: "+directionType[selectedItem.row])
      //alert("Номер транспорта: " + transportRoute[selectedItem.row]);
    }
  }
  chart.draw(data, options);
}
