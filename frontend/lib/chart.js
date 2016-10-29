var start_time;
var interval;
var time;

function drawBasic() {

  var fullArr = [["Время суток,ч", "Интервал, мин"]];

  $.each(dataJSON,function(key, val){
    if(val.directionId && val.interval < 240) {
      time = new Date(val.startLocation.timestamp*1000);
      start_time = time.getHours();
      interval = val.interval / 60;
      fullArr.push([start_time, interval]);
    }
  });

  var data = new google.visualization.arrayToDataTable(fullArr);

  var options = {
    width: 1300,
    height: 600,
    chart: {
      title: "График интервала по суточному времени"
    },
    series: {
      0:{axis:"interval"}
    },
    hAxis: {
      tacks: [0,23]
    },
    axes:{
      y:{
        interval:{label:"Интервал, мин"}
      }
    }
  }
  var chart = new google.charts.Bar(document.getElementById('chartHistogram'));
  chart.draw(data, options);
}
