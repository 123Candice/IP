<?php
	if(isset($model['errorMessage'])){
		echo $model['errorMessage'];
		die;
	}
?>

<script type="text/javascript">
	$(function(){
		$(".read-only").closest("div").removeClass("disabled");
		$(".read-only").closest("div").css("cursor", "default");

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

		var nFlight = <?php echo count($model['bookedFlight']); ?>;
		if (nFlight == 0){
			$(".panel").hide();
			$("#no-booking").text("You have no booking");
		}

		var viewBooking = <?php echo isset($model['activeTab'])? "true" : "false" ?>;

		if (viewBooking){
			$("#view-booking").show();
			$("#add-booking").hide();
		}
		else{
			$("#view-booking").hide();
			$("#add-booking").show();	
		}

		function deleteSelectedFlights(){
			$("#delete-selected-form").html("");
			$.each($(".flight-select:checked"), function(index, element){
				var flightIndex = $(element).val() - 1;
				var hidden = $("<input type='hidden' name='index[]'>");
				hidden.val(flightIndex);
				$("#delete-selected-form").append(hidden);
			});
			$("#delete-selected-form").submit();
		}
		/*
		function updateDeleteBtn(){
			if ($(".flight-select:checked").length == 0){
				$("#delete-selected-btn").prop("disabled", true);
			}
			else{
				$("#delete-selected-btn").prop("disabled", false);
			}
		}

		updateDeleteBtn();

		$(".flight-select").on("ifToggled", function(){
			updateDeleteBtn();
		});*/

		$(".delete-flight").click(function(){
			var btnAction = function(){ $("#delete-all-form").submit()};
			var dialogMessage = "Are you sure to delete all flights?";
			if ($(this).attr("id") == "delete-selected-btn"){
				if ($(".flight-select:checked").length == 0) {displayError(); return false;}
				btnAction = deleteSelectedFlights;
				dialogMessage = "Are you sure to delete selected flight(s)?";
			}

			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: "Confirm delete",
				message: dialogMessage,
				buttons: [{
					label: "<span class='glyphicon glyphicon-ok'></span> Yes",
					cssClass: "btn-danger",
					action: function(dialog){
						btnAction();
					}
				},{
					label: "<span class='glyphicon glyphicon-remove'></span> No",
					cssClass: "btn-success",
					action: function(dialog){
						dialog.close();
					}
				}]
			});

			return false;
		});

		function displayError(){
			var message = "<strong>Please select at least one flight to delete</strong>";
			var alertDiv = "<div class='alert alert-danger alert-dismissible' role='alert' style='display:none;'>";
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

<div id='alert-placeholder' style='position: fixed; top: 20%; left:30%; width: 40%; z-index: 1'></div>

<div><h4 id="no-booking"></h4></div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Your booked flights</h3>
	</div>

	<div class="panel-body">
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

			<span id="view-booking">
				<button id="delete-selected-btn" class="btn btn-danger delete-flight">Delete selected flights</button>
				<form id="delete-selected-form" style="display:none;" method="post" action="<?php echo router::createURL("booking", "delete") ?>">
				</form>
			</span>
			<span id="add-booking">
				<form id="delete-all-form" action="<?php echo router::createURL("booking", "deleteAll")?>" method="post" style="display: inline;">
					<input type="submit" class="btn btn-danger delete-flight" value="Clear all booked flights">
				</form>
				<a href="<?php echo router::createURL("flight", "search")?>" class="btn btn-success">Book more flight</a>
			</span>
			<a class="btn btn-info" href="<?php echo router::createURL("checkout", "step1")?>">Proceed to checkout</a>
	</div>
</div>