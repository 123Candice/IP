<?php
	if (isset($model["errorMessage"])){
		echo $model["errorMessage"];
		die;
	}
?>

<script type="text/javascript">
	$(function(){
		var selectedSeat = $(".select-seat:checked").length;

		$(".select-seat").on("ifUnchecked", function(){
			selectedSeat--;
			updateSeatCount();
			$(this).closest("tr").find("input").iCheck("uncheck");
		});

		$(".select-seat").on("ifChecked", function(){
			selectedSeat++;
			updateSeatCount();
		});

		$(".select-child, .select-wheelchair, .select-diet").on("ifChecked", function(){
			$(this).closest("tr").find("input.select-seat").iCheck("check");
		});

		updateSeatCount();

		function updateSeatCount(){
			var seat = " seat";
			if (selectedSeat >= 2) seat += "s";
			seat = selectedSeat + seat + " selected";
			$("#seat-count").text(seat);
		}

		$("#book-flight-form").submit(function(){
			if (selectedSeat == 0){
				displayError();
				return false;
			}
		});

		function displayError(){
			var message = "<strong>Please select at least one seat</strong>";
			var alertDiv = "<div class='alert alert-danger alert-dismissible' role='alert' style='display:none'>";
			alertDiv += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
			alertDiv += message + "</div>";
			$("#alert-placeholder").html(alertDiv);

			$(".alert").fadeIn(500, function(){
				$(".alert").fadeTo(2000, 500).slideUp(500, function(){
					$(".alert").alert('close');
				});
			});
		}
	});
</script>

<form id="book-flight-form" action="<?php echo $router::createURL("booking", "add")?>" method="post">
	
	<!-- hidden input for retriving flight information -->
	<input type="hidden" name="route_no" value="<?php echo $model['flight']['route_no'] ?>">

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Your Flight Booking Detail</h3>
		</div>

		<div class="panel-body">
			<h4>Flight Detail</h4>
			<div class="row">
				<div class="col-md-4">From: <strong><?php echo $model['flight']['from_city']; ?></strong></div>
				<div class="col-md-4">To: <strong><?php echo $model['flight']['to_city']; ?></strong></div>
				<div class="col-md-4">Price: <strong>$<?php echo $model['flight']['price']; ?></strong></div>
			</div>

			<hr/>
			<h4>Select Seats</h4>
			<table class="table table-striped table-hover">
				<thead>
					<td class="col-md-3">Select</td>
					<td class="col-md-3">Child</td>
					<td class="col-md-3">Wheel Chair</td>
					<td class="col-md-3">Special Diet</td>
				</thead>
				<?php 
					for($i=0; $i<5; $i++){
						echo "<tr><td><input type='checkbox' name='seat[$i]' class='select-seat'></td>";
						echo "<td><input type='checkbox' name='seat[$i][child]' class='select-child'></td>";
						echo "<td><input type='checkbox' name='seat[$i][wheelchair]' class='select-wheelchair'></td>";
						echo "<td><input type='checkbox' name='seat[$i][diet]' class='select-diet'></td></tr>";
					}
				?>
			</table>
			<hr/>
			<h4 id="seat-count"></h4>
			<hr/>
			<input type="submit" class="btn btn-primary" value="Add To Bookings">
		</div>
	</div>
</form>

<div id='alert-placeholder' style='position: fixed; top: 20%; left:30%; width: 40%; z-index: 1'></div>