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
					alert("ќшибка");
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
		
		var msg = document.getElementById('msg');
		msg.innerHTML = JSON.stringify(data);
	}