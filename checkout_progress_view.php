<!-- Form progress wizard - for checkout process -->
<link rel="stylesheet" href="<?php echo PUBLIC_DIR?>/css/form-progress.css">

<div class="row bs-wizard hidden-xs" style="border-bottom:0;">

	<div class="col-sm-3 bs-wizard-step">
		<div class="text-center bs-wizard-stepnum">Personal Details</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="<?php echo router::createURL("checkout", "step1")?>" class="bs-wizard-dot"></a>
	</div>

	<div class="col-sm-3 bs-wizard-step">
		<div class="text-center bs-wizard-stepnum">Payment Details</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="<?php echo router::createURL("checkout", "step2")?>" class="bs-wizard-dot"></a>
	</div>

	<div class="col-sm-3 bs-wizard-step">
		<div class="text-center bs-wizard-stepnum">Review Details</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="<?php echo router::createURL("checkout", "step3")?>" class="bs-wizard-dot"></a>
	</div>

	<div class="col-sm-3 bs-wizard-step">
		<div class="text-center bs-wizard-stepnum">Complete Payment</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="<?php echo router::createURL("checkout", "step4")?>" class="bs-wizard-dot"></a>
	</div>

</div>

<script type="text/javascript">
	$(function(){
		var step = <?php echo $model['step']?>;
		var stepDivs = $(".bs-wizard-step");

		var i=0;
		for (i=0; i<step-1; i++){
			$(stepDivs[i]).addClass("complete")
		}

		if (step >= 0)
			$(stepDivs[step-1]).addClass("active");

		for (i=step; i<=4; i++){
			$(stepDivs[i]).addClass("disabled")
		}
	})
</script>