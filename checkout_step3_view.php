<?php
	$controller->executeAction("progress");
	if (isset($model['errorMessage'])){
		echo "<div><h4>{$model['errorMessage']}</h4></div>";
		die;
	}
?>

<script type="text/javascript">
	$(function(){
		$(".collapseControl").click(function(){
			if ($(this).hasClass("glyphicon-menu-up"))
				hide($(this));
			else show($(this));
		});

		function show(e){
			$(e).closest("table").find("tbody.collapse").addClass("in");
			$(e).closest("tr").addClass("info");
			$(e).removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
			
		}

		function hide(e){
			$(e).closest("table").find("tbody.collapse").removeClass("in");
			$(e).closest("tr").removeClass("info");
			$(e).removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
		}

		$(".collapseControl").trigger("click");

		$(".read-only").closest("div").removeClass("disabled");
		$(".read-only").closest("div").css("cursor", "default");
	})
</script>

<div class="col-xs-1"></div>
<div class="col-xs-10">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Complete Booking - stage 3 of 4 - Review Details</h3>
		</div>

		<div class="panel-body">
			<h4>Your details</h4>

			<?php
				$personalDetail = $model['personalDetail'];
				$paymentDetail = $model['paymentDetail'];
			?>

			<div class="row">
				<div class="col-md-12"><strong>Name: </strong>
				<?php echo "$personalDetail->firstName $personalDetail->lastName"?></div>
			</div>

			<div class="row">
				<div class="col-md-12">
				<strong>Address: </strong>
				<?php
					echo $personalDetail->address1;
					if ($personalDetail->address2 != '')
						echo ', ' . $personalDetail->address2;

					echo ', ' . $personalDetail->suburb;
					if ($personalDetail->state != '')
						echo ', ' . $personalDetail->state;

					if ($personalDetail->postcode != '')
						echo ', ' . $personalDetail->postcode;

					echo ', ' . $personalDetail->country;
				?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12"><strong>Email: </strong><?php echo $personalDetail->email?></div>
			</div>

			<!--<div class="row">
				<div class="col-md-12"><strong>Credit card name: </strong><?php echo $paymentDetail->cardName?></div>
			</div>

			<div class="row">
				<div class="col-md-12"><strong>Credit card number: ********</strong><?php echo substr($paymentDetail->cardNumber, -4)?></div>
			</div>-->
			<div class="row">
				<div class="col-md-12"><strong>Credit card details supplied</strong></div>
			</div>

			<hr/>

			<h4>Your booked flights</h4>

			<?php

				$flyIndex = 1;
				foreach ($model['bookedFlight'] as $flight) {
					echo "<table class='table table-bordered'>";
					$flightSelect = "Flight #$flyIndex &nbsp;";
					if (isset($model['renderSelect']))
						$flightSelect .= "<input type='checkbox' class='flight-select' value='$flyIndex'>";

					$flightDetail = "From <strong>{$flight['flightDetail']['from_city']}</strong> to <strong>{$flight['flightDetail']['to_city']}</strong>. ";
					$flightPrice = "Price: <strong>&#36;{$flight['flightDetail']['price']}</strong>";
					$flightCollapse = "<span class='pull-right glyphicon glyphicon-menu-down collapseControl' style='cursor: pointer'></span>";
					echo "<thead><tr><td class='col-md-3'>$flightSelect</td><td class='col-md-9' colspan=3>$flightDetail $flightPrice $flightCollapse</td><tr></thead>";
					$rowSpan = count($flight['seats']);

					$i=1;
					echo "<tbody class='collapse'><tr class='active'><th>Seats</th><th>Child</th><th>Wheelchair</th><th>Special Diet</th></tr>";
					foreach($flight['seats'] as $seat){
						$seatNo = "Seat #$i";
						$isChild = "";
						$isWheelchair = "";
						$isDiet = "";
						if (is_array($seat)){
							if (isset($seat['child'])) $isChild = "checked";
							if (isset($seat['wheelchair'])) $isWheelchair = "checked";
							if (isset($seat['diet'])) $isDiet = "checked";
						}
						$child = "<input type='checkbox' class='read-only' disabled $isChild>";
						$wheelchair ="<input type='checkbox' class='read-only' disabled $isWheelchair>";
						$diet ="<input type='checkbox' class='read-only' disabled $isDiet>";
						$i++;

						echo "<tr><td class='col-md-3'>$seatNo</td><td class='col-md-3'>$child</td>";
						echo "<td class='col-md-3'>$wheelchair</td><td class='col-md-3'>$diet</td></tr>";
					}

					$flyIndex++;
					echo "</tbody></table>";
				}
			?>

			<hr/>
			<form action="<?php echo router::createURL("checkout", "step3")?>" method="post">
				<input type="submit" class="btn btn-info pull-right" value="Stage 4 - Confirm Payment">
			</form>
		</div>
	</div>
</div>