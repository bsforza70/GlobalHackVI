<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
		  integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
			integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
			crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
</head>
<body>
	<canvas id="myChart" width="1000" height="600"></canvas>
	<script>
		$(document).ready(function() {
			$.ajax({
				url: "graph-helper.php",
				success: function(result) {
	    			var ctx = document.getElementById("myChart");
					var scatterChart = new Chart(ctx, {
						type: 'line',
						data: JSON.parse(result),
						options: {
							responsive: false
						}
					});
	        	},
	        	error: function(result) {
	        		console.log("ajax returned an error");
	        	},
	        	type: 'POST',
        		data: {
        			coc_or_host: "coc",
        			provider_id: "1",
        			min_date: "8",
        			max_date: "4",
        			increments: "6",
        			tables: ["intake"]
        		}
  			});

  			$(function() {
				var sliderRange = $("#slider-range");
				var amt = $("#amount");

				sliderRange.slider({
					range: true,
					min: 0,
					max: 500,
					values: [75, 300],
					slide: function (event, ui) {
						amt.val("$" + ui.values[0] + " - $" + ui.values[1]);
					}
				});

				amt.val("$" + sliderRange.slider("values", 0) +
					" - $" + sliderRange.slider("values", 1));
			});
		});
	</script>

	<p>
		<label for="amount">Price range:</label>
		<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
	</p>
	<div id="slider-range"></div>
	
</body>
</html>
