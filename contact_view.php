<?php
	if (isset($model['errorMessage'])){
		echo "<div><h4>{$model['errorMessage']}</h4></div>";
		die;
	}
?>

<div class="row">

	<div class="col-md-8 col-md-offset-2">
		<?php 
			if(isset($model['success'])) 
				echo "<div class='alert alert-success'>Your email has been sent. Thank you for contacting us.</div>"; 
		?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">Contact Us</div>
		</div>

		<div class="panel-body">
			<form class="form" method="post">
				<?php $contact = isset($model['contact']) ? $model['contact'] : new ContactModel(); ?>
				<div class="row">
					<div class="form-group col-sm-6">
						<label>Subject</label>
						<?php echo $contact->inputFor("subject", array("class" => "form-control")) ?>
					</div>

					<div class="form-group col-sm-6">
						<label>Your Email</label>
						<?php echo $contact->emailFor("email", array("class" => "form-control")) ?>						
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label>First Name</label>
						<?php echo $contact->inputFor("firstName", array("class" => "form-control")) ?>					
					</div>

					<div class="form-group col-sm-6">
						<label>Last Name</label>
						<?php echo $contact->inputFor("lastName", array("class" => "form-control")) ?>						
					</div>
				</div>

				<div class="row">
					<div class="form-group col-xs-12">
						<label>Message</label>
						<?php echo $contact->textAreaFor("message", array("class" => "form-control", "style" => "min-width: 100%; max-width: 100%; min-height: 100px; overflow: scroll;")) ?>
					</div>
				</div>

				<input type="submit" class="btn btn-primary" value="Send email">
			</form>
		</div>
	</div>
	</div>
</div>