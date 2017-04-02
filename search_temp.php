<?php
	include_once("connection.php");

	$query = "select * from flights";
	$result = $conn->query($query);

	$allFlights = array();
	while($row = $result->fetch_assoc()) {
		$allFlights[] = $row;
	}

	$conn->close();

	$flyFromArr = "[";
	$flyToArr = "[";

	foreach($allFlights as $flight){
		$flyFromArr .= "'$flight[from_city]', ";
		$flyToArr .= "'$flight[to_city]', ";
	}

	$flyFromArr[strlen($flyFromArr)-2] = ']';
	$flyToArr[strlen($flyToArr)-2] = ']';
?>

<script type="text/javascript">
	$(function(){


		var allFlyFrom = [];
		var allFlyTo = [];

		allFlyFrom = <?php echo "$flyFromArr;"; ?>
		allFlyTo = <?php echo "$flyToArr;"; ?>


		var flyFrom=allFlyFrom.filter(function(item,index,array){
		    return index==array.indexOf(item);
		});

		var flyTo=allFlyTo.filter(function(item,index,array){
		    return index==array.indexOf(item);
		});

		flyFrom.sort();
		flyTo.sort();

		$("#fly-from").typeahead(
		{
			minLength: 0,
			items: 9999,
			source: flyFrom
		});

		$("#fly-to").typeahead(
		{
			minLength: 0,
			items: 9999,
			source: flyTo
		});

		$("#fly-from").on('focus', $("#fly-from").typeahead.bind($("#fly-from"), 'lookup'));
		$("#fly-to").on('focus', $("#fly-to").typeahead.bind($("#fly-to"), 'lookup'));

		$(".fly-input").on("input", function(e){
			if ($(this).val() == ""){
				$(this).siblings(".searchclear").hide();
			}else{
				$(this).siblings(".searchclear").show();
			}
		});

		$(".searchclear").click(function(){
			$(this).siblings("input").val("");
			$(this).hide();
		});

		$(".fly-input").change(function(){
			if ($(this).val() == ""){
				$(this).siblings(".searchclear").hide();
			}else{
				$(this).siblings(".searchclear").show();
			}
		});

	});
</script>

<style type="text/css">
	.searchclear {
	    position: relative;
	    float: right;
	    right: 8px;
	    top: 32px;
	    bottom: 0px;
	    height: 20px;
	    margin: 0;
	    font-size: 20px;
	    cursor: pointer;
	    color: #ccc;
	    display: none;
	}

	.scrollable-menu {
	    height: auto;
	    max-height: 200px;
	    overflow-x: hidden;
	}
</style>

<form>
	<div class="row">
		<div class="panel panel-primary">

			<div class="panel-heading">
				<h3 class="panel-title">Search Flight</h3>
			</div>

			<div class="panel-body">
				<form class="clearfix">
					<div class="row form-group clearfix">
						<div class="col-md-5">
							<label for="fly-from">Fly from</label>
							<span id="clear-from" class="searchclear glyphicon glyphicon-remove-circle"></span>
							<input id="fly-from" type="text" class="form-control fly-input" placeholder="Select City" autocomplete="off">
						</div>

						<div class="col-md-5 col-md-offset-1">
							<label for="fly-to">Fly to</label>
							<span class="searchclear glyphicon glyphicon-remove-circle"></span>
							<input id="fly-to" type="text" class="form-control fly-input" placeholder="Select City" autocomplete="off">
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Search</button>
				</form>
			</div>
		</div>
	</div>
</form>