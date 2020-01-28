<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>



	<style type="text/css">
		::selection {
			background-color: #E13300;
			color: white;
		}

		::-moz-selection {
			background-color: #E13300;
			color: white;
		}

		body {
			background-color: #fff;
			margin: 40px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#body {
			margin: 0 15px 0 15px;
		}

		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

		#container {
			margin border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}

		.box {
			width: 100%;
			max-width: 650px;
			margin: 0 auto;
		}
	</style>
</head>

<body>

	<div id="container">
		<h1>Pärnu Linna Sport</h1>

		<div id="body">
			<p>See on avaleht</p>

			Linn

			<form action="fullcalendar" method="get">
				<input type="text" id="region" list="regions">
				<datalist id="regions">
					<?php
					foreach ($regions as $row) {
						echo '<option value="' . $row->name . '">' . $row->name . '</option>';
					}
					?>
				</datalist>

				<br><br>
				Asutus<br>
				<input type="text" id="building" list="buildings">
				<datalist id="buildings">

					<?php foreach ($buildings as $each) { ?>
						<option value="<?php echo $each->name; ?>"><?php echo $each->name; ?></option>';
					<?php } ?>

				</datalist>
				<br><br>
				Saal<br>
				<input type="text" id="room" list="rooms">
				<datalist id="rooms">
					<?php foreach ($rooms as $each) { ?>
						<option value="<?php echo $each->name; ?>"><?php echo $each->name; ?></option>';
					<?php } ?>

				</datalist> <br>


				<br>

				<p>Vali kuupäev: <br> <input name="date" type="text" value="<?php echo (date("d.m.Y")) ?>"> </p>
				<input type="submit">
			</form>






			<div class="form-group">
				<select name="regions1" id="regions1" class="form-control input-lg">
					<option value="">Select Country</option>
					<?php
					foreach ($regions as $row) {
						echo '<option value="' . $row->id . '">' . $row->name . '</option>';
					}
					?>
				</select>
			</div>

			<br />
			<div class="form-group">
				<select name="state" id="state" class="form-control input-lg">
					<option value="">Select State</option>
				</select>
			</div>

			<br />
			<div class="form-group">
				<select name="citys" id="citys" class="form-control input-lg">
					<option value="">Select City</option>
				</select>
			</div>
		</div>



		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
	</div>

</body>

</html>


<script>
	$(document).ready(function() {
		$('#regions1').change(function() {
			var country_id = $('#regions1').val();

			if (country_id != '') {
				$.ajax({
					url: "<?php echo base_url(); ?>calendar/fetch_state",
					method: "POST",
					data: {
						country_id: country_id
					},
					success: function(data) {

						$('#state').html(data);
						$('#citys').html('<option value="">Vali asutus</option>');

					}
				});
			} else {
				$('#state').html('<option value="">Select State</option>');
				$('#citys').html('<option value="">Select rerre</option>');
			}
		});

		$('#state').change(function() {
			var state_id = $('#state').val();
			console.log(state_id);
			if (state_id != '') {
				console.log("data");
				$.ajax({
					url: "<?php echo base_url(); ?>calendar/fetch_city",
					method: "POST",
					data: {
						state_id: state_id
					},
					success: function(data) {
						console.log(data);
						$('#citys').html(data);
					},
				});

			} else {

				$('#city').html('<option value="">Select ruums</option>');
			}
		});


		// $("region").on('input', function() {
		// 	var country_id = $('#regions').val();
		// 	console.log("it works!");
		// 	if (country_id != '') {
		// 		$.ajax({
		// 			url: "<?php echo base_url(); ?>calendar/fetch_state",
		// 			method: "POST",
		// 			data: {
		// 				country_id: country_id
		// 			},
		// 			success: function(data) {

		// 				$('#building').html(data);
		// 				$('#room').html('<option value="">Vali asutus</option>');

		// 			}
		// 		});
		// 	} else {
		// 		$('#building').html('<option value="">Select State</option>');
		// 		$('#room').html('<option value="">Select rerre</option>');
		// 	}
		// });

		// $("input").on('input', function() {
		// 	var state_id = $('#building').val();
		// 	console.log(state_id);
		// 	if (state_id != '') {
		// 		console.log("data");
		// 		$.ajax({
		// 			url: "<?php echo base_url(); ?>calendar/fetch_city",
		// 			method: "POST",
		// 			data: {
		// 				state_id: state_id
		// 			},
		// 			success: function(data) {
		// 				console.log("data");
		// 				$('#room').html(data);
		// 			},
		// 		});

		// 	} else {

		// 		$('#room').html('<option value="">Select ruums</option>');
		// 	}
		// });

		$("#region").on("change keydown input paste", function() {
			var selectedOption = $("#regions option[value='" + $(this).val() + "']");
			var selectedPerson = parseInt(selectedOption.attr('data-empid-clean'));

			var country_id = this.value;

			// if ($('#regions').find('option').filter(function() {
			// 		console.log(inputValue);
			// 		return this.value == inputValue;

			// 	}).length) {
			// 	//your code as per need

			// 	alert(inputValue);

			// }
			console.log("it works " + this.value);
			if (country_id != '') {
				$.ajax({
					url: "<?php echo base_url(); ?>calendar/fetch_state",
					method: "POST",
					data: {
						country_id: country_id
					},
					error: function(req, err) {
						console.log('my error message' + err);
					},
					success: function(data) {
						console.log($("#buildings").html(data));
						$("#buildings").empty();

						for (var i = 0; i < data.length; i++) {
							$("#buildings").append("<option value='" +
								data[i].name + "'></option>");
						}

						// $('#building').html(data);
						// $('#room').html('<option value="">Vali asutus</option>');

					}
				});
			} else {
				$('#building').html('<option value="">Select State</option>');
				$('#room').html('<option value="">Select rerre</option>');
			}

		});


	});
</script>