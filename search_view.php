<script type="text/javascript">
	$(function(){
		$(".chosen-select").chosen({
			allow_single_deselect: true,
			no_results_text: "No city found!"
		});

		/*$(".select-flight").on("ifChecked", function(){
			$("#add-to-booking").prop("disabled", false);
		});*/

		//$("#add-to-booking").prop("disabled", true);
		$("#add-to-booking-form").submit(function(){
			if($(".select-flight:checked").length == 0){
				displayError();
				return false;
			}
		});

		function displayError(){
			var message = "<strong>Please select one flight to add to booking</strong>";
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
<div id='alert-placeholder' style='position: fixed; top: 20%; left:30%; width: 40%; z-index: 1'></div>
<form>
	<div class="row">
		<div class="panel panel-primary">

			<div class="panel-heading">
				<h3 class="panel-title">Search Flight</h3>
			</div>

			<div class="panel-body">
				<form id="search-form" action="<?php $router->createURL("fligh", "search") ?>">
					<div class="row form-group clearfix">
						<div class="col-md-5">
							<label for="fly-from">Fly from</label>
							<select class="chosen-select" data-placeholder="Select City" style="width:100%" name="from" tabindex="2">
								<option value=""></option>
								<?php
									foreach ($model["flyFromList"] as $flyFrom) {
										if($flyFrom == $model["from"])
											$selected = "selected";
										else $selected = "";
										echo "<option value='$flyFrom' $selected>$flyFrom</option>";
									}
								?>
							</select>
						</div>

						<div class="col-md-5 col-md-offset-1">
							<label for="fly-to">Fly to</label>
							<select class="chosen-select" data-placeholder="Select City" style="width:100%" name="to">
								<option value=""></option>
								<?php
									foreach ($model["flyToList"] as $flyTo) {
										if($flyTo == $model["to"])
											$selected = "selected";
										else $selected = "";
										echo "<option value='$flyTo' $selected>$flyTo</option>";
									}
								?>
							</select>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Search</button>
				</form>
			</div> <!-- End Panel Body -->
		</div> <!-- End Search Form Panel -->

		<form id="add-to-booking-form" action="<?php echo $router::createURL("flight", "book") ?>" method="get">
			<div class="panel panel-info" <?php if($model["isSearch"] == false) echo "style='display:none'" ?>>
				<div class="panel-heading">
					<h3 class="panel-title">
						<?php 
							if(count($model["searchResult"]) == 0) echo "No Result Found!";
							else echo "Search Result";
						?>
					</h3>
				</div>

				<div class="panel-body" <?php if(count($model["searchResult"]) == 0) echo "style='display:none'"?>>
					<table class="table table-striped table-hover">
						<thead>
							<td>From</td>
							<td>To</td>
							<td>Select</td>
						</thead>
						<?php
							foreach($model["searchResult"] as $flight){
								echo "<tr><td>{$flight['from_city']}</td>";
								echo "<td>{$flight['to_city']}</td>";
								echo "<td><input type='radio' class='select-flight' name='route_no' value='{$flight['route_no']}'></td></tr>";
							}
						?>
					</table>
				</div>

				<div class="panel-footer" <?php if(count($model["searchResult"]) == 0) echo "style='display:none'"?>>
					<input id="add-to-booking" type="submit" class="btn btn-info" value="Book Selected Flight">
				</div>
			</div> <!-- End search result panel -->
		</form>
	</div>
</form>