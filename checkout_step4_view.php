<?php
	$controller->executeAction("progress");
	if (isset($model['errorMessage'])){
		echo "<div><h4>{$model['errorMessage']}</h4></div>";
		die;
	}
?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h4 style="text-align: center"><strong>Thank You!</strong><br/> .... your booking has been completed and a confirmation email has been sent to your email address</h4>
	</div>
</div>