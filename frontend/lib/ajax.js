	var dataJSON;
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

		dataJSON = data;
		google.charts.load('current', {packages: ['bar']});
		google.charts.setOnLoadCallback(drawBasic);
		var msg = document.getElementById('msg');
		msg.innerHTML = JSON.stringify(dataJSON);
	}
