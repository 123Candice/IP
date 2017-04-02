<?php
	$controller->executeAction("progress");
	if (isset($model['errorMessage'])){
		echo "<div><h4>{$model['errorMessage']}</h4></div>";
		die;
	}
?>

<style type="text/css">
	.form-group.required label:after{
		content:"*";
		color:red;
	}
</style>

<script type="text/javascript">
	$(function(){
		$(".chosen-select").chosen({
			no_results_text: "No country found!"
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

	   /* $("form").validate({
	    	rules: {
	    		"#personalDetail[firstName]": "required"
	    	}
	    });*/

	    $("select[name='personalDetail[country]'").change(function(){
	    	var state = $("input[name='personalDetail[state]'");
	    	var postcode = $("input[name='personalDetail[postcode]'");

	    	if ($(this).val() == "Australia"){
	    		$(state).prop("required", true);
	    		if (!$(state).closest("div").hasClass("required"))
	    			$(state).closest("div").addClass("required");

	    		$(postcode).prop("required", true);
	    		if (!$(postcode).closest("div").hasClass("required"))
	    			$(postcode).closest("div").addClass("required");
	    	} else{
	    		$(state).prop("required", false);
	    		$(state).closest("div").removeClass("required");

	    		$(postcode).prop("required", false);
	    		$(postcode).closest("div").removeClass("required");
	    	}
	    });

	    $("select[name='personalDetail[country]'").trigger("change");
	});
</script>

<div class="col-xs-1"></div>
<div class="col-xs-10">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Complete Booking - stage 1 of 4 - Personal Details</h3>
		</div>

		<div class="panel-body">

			<form id="personal-detail-form" class="form" method="post">
				<?php $personalDetail = $model['personalDetail']; ?>
				<div class="row">
					<div class="form-group col-md-6 required">
						<label>Given Name</label>
						<?php echo $personalDetail->inputFor("firstName", array("class" => "form-control")) ?>
					</div>


					<div class="form-group col-md-6 required">
						<label>Family Name</label>
						<?php echo $personalDetail->inputFor("lastName", array("class" => "form-control")) ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 required">
						<label>Address Line 1</label>
						<?php echo $personalDetail->inputFor("address1", array("class" => "form-control")) ?>
					</div>

					<div class="form-group col-md-6">
						<label>Address Line 2</label>
						<?php echo $personalDetail->inputFor("address2", array("class" => "form-control")) ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 required">
						<label>Suburb</label>
						<?php echo $personalDetail->inputFor("suburb", array("class" => "form-control")) ?>
					</div>

					<div class="form-group col-md-4 required">
						<label>State</label>
						<?php echo $personalDetail->inputFor("state", array("class" => "form-control")) ?>
					</div>

					<div class="form-group col-md-4 required">
						<label>Postcode</label>
						<?php echo $personalDetail->inputFor("postcode", array("class" => "form-control")) ?>
					</div>
					
				</div>

				<div class="row">
					<div class="form-group col-md-6 required">
						<label>Country</label>
						<?php 
							echo $personalDetail->selectFor("country", $model['countryList'], array("class" =>"chosen-select", "style" => "width:100%"));
						?>
					</div>

					<div class="form-group col-md-6 required">
						<label>Email Address</label>
						<?php echo $personalDetail->emailFor("email", array("class" => "form-control")) ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						<label>Mobile Phone</label>
						<?php echo $personalDetail->inputFor("mobile", array("class" => "form-control")) ?>
					</div>

					<div class="form-group col-md-4">
						<label>Business Phone</label>
						<?php echo $personalDetail->inputFor("businessPhone", array("class" => "form-control")) ?>
					</div>

					<div class="form-group col-md-4">
						<label>Work Phone</label>
						<?php echo $personalDetail->inputFor("workPhone", array("class" => "form-control")) ?>
					</div>
				</div>
			
				<hr/>

				<input type="submit" class="btn btn-info pull-right" value="Stage 2 - Payment Details">
			</form>

			<p class="small text-danger">Note: <ins><strong>State</strong> and <strong>Postcode</strong> are optional fields for booking made from outside Australia</ins></p>
			<div class="clearfix"></div>

		</div> <!-- End panel body -->

	</div> <!-- End panel -->
</div>