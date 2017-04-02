<?php
	$controller->executeAction("progress");
	if (isset($model['errorMessage'])){
		echo "<div><h4>{$model['errorMessage']}</h4></div>";
		die;
	}
?>

<script type="text/javascript">
	$(function(){
		$(".chosen-select").chosen({
			disable_search_threshold: 20
		});

		function validate(e){
			var input = $(e.target);

        	if (e.target.validity.patternMismatch){
        		var errorMsg = "Invalid input";
        		if ($(input).attr("patternError") != null)
         			errorMsg = $(input).attr("patternError");
         		e.target.setCustomValidity(errorMsg);
        	}
        	else{
        		e.target.setCustomValidity("");
        	}

        	return true;
		};

		var inputs = $("input");
		for (var i = 0; i < inputs.length; i++) {
	        inputs[i].oninvalid = function(e) {
	        	validate(e);
	        };

	        inputs[i].oninput = function(e){
	        	validate(e);
	        };
	    }

	    $("form#payment-form").submit(function(){
	    	var year = $(this).find("select[name='paymentDetail[expireYear]']").val();
	    	var month = $(this).find("select[name='paymentDetail[expireMonth]']").val();

	    	var currentTime = new Date();
	    	var currentYear = currentTime.getFullYear();
	    	var currentMonth = currentTime.getMonth() + 1;

	    	if (year < currentYear){ displayExpireError(); return false; }
	    	if (year == currentYear && month < currentMonth) { displayExpireError(); return false; }

	    	return true;
	    });

	    function displayExpireError(){
	    	var message = "<strong>Your credit card has expired</strong>";
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
	})
</script>

<div class="col-xs-1"></div>
<div class="col-xs-10">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Complete Booking - stage 2 of 4 - Payment Details</h3>
		</div>

		<?php $personalDetail = $model['personalDetail'] ?>

		<div class="panel-body">
			<h4>Your personal details</h4>
			<div class="row">
				<div class="col-md-12"><strong>Name: </strong>
				<?php echo $personalDetail->firstName . ' ' . $personalDetail->lastName?></div>
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
				<div class="col-md-12">
				<strong>Email: </strong><?php echo $personalDetail->email?>
				<?php
					if ($personalDetail->mobile != '')
						echo '<br/><strong>Mobile Phone: </strong>' . $personalDetail->mobile . "<br/>";

					if ($personalDetail->businessPhone != '')
						echo '<br/><strong>Business Phone: </strong>' . $personalDetail->businessPhone . "<br/>";

					if ($personalDetail->workPhone != '')
						echo '<br/><strong>Work Phone: </strong>' . $personalDetail->workPhone . "<br/>";
				?>
				</div>
			</div>

			<hr/>

			<h4>Payment Detail</h4>

			<form class="form" id="payment-form" method="post">
				<?php $paymentDetail = $model['paymentDetail']?>
				<div class="row">
					<div class="form-group col-sm-3">
						<label>Creadit Card Type</label> <br/>
						<?php echo $paymentDetail->selectFor("cardType", array("Visa", "Diners", "Mastercard", "Amex"), array("class" => "chosen-select", "style" => "width:100%")) ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label>Credit Card Name</label>
						<?php echo $paymentDetail->inputFor("cardName", array("class"=>"form-control", "autocomplete" => "off")) ?>
					</div>

					<div class="form-group col-sm-6">
						<label>Credit Card Number</label>
						<?php echo $paymentDetail->inputFor("cardNumber", array("class"=>"form-control", "autocomplete" => "off")) ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-3">
						<label>Expire Month</label> <br/>
						<?php
							$monthList = array();
							for ($i=1; $i<=12; $i++)
								array_push($monthList, $i);

							echo $paymentDetail->selectFor("expireMonth", $monthList, array("class" => "chosen-select", "style" => "width: 100%"));
						?>
					</div>

					<div class="form-group col-sm-3 col-sm-offset-1">
						<label>Expire Year</label> <br/>
						<?php
							$currentYear = (int)date("Y");
							$yearList = array();
							for ($i=$currentYear; $i<=($currentYear+5); $i++)
								array_push($yearList, $i);

							echo $paymentDetail->selectFor("expireYear", $yearList, array("class" => "chosen-select", "style" => "width: 100%"));
						?>
					</div>

					<div class="form-group col-sm-3 col-sm-offset-1">
						<label>Security Code</label>
						<?php echo $paymentDetail->inputFor("securityCode", array("class"=>"form-control", "autocomplete" => "off"), false) ?>
					</div>
				</div>

				<hr/>

				<input type="submit" class="btn btn-info pull-right" value="Stage 3 - Review Bookings and Details">
			</form>

		</div> <!-- end panel body -->
	</div>
</div>

<div id='alert-placeholder' style='position: fixed; top: 20%; left:30%; width: 40%;'></div>