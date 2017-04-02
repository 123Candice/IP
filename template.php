<!DOCTYPE HTML>
<html>
<head>
	<title>Internet Programming - Assignment 1</title>

	<!-- jQuery -->
	<script src="<?php echo PUBLIC_DIR?>/js/jquery-1.12.0.min.js"></script>

	<!-- Boostrap-->
	<link rel="stylesheet" href="<?php echo PUBLIC_DIR?>/css/bootstrap.min.css">
	<script src="<?php echo PUBLIC_DIR?>/js/bootstrap.min.js"></script>

	<!-- Chosen plugin -->
	<link rel="stylesheet" href="<?php echo PUBLIC_DIR?>/css/chosen.css">
	<script src="<?php echo PUBLIC_DIR?>/js/chosen.jquery.js"></script>

	<!-- iCheck - fancy checkboxes and radio buttons -->
	<link rel="stylesheet" href="<?php echo PUBLIC_DIR?>/css/blue.css">
	<script src="<?php echo PUBLIC_DIR?>/js/icheck.js"></script>

	<!-- Boostrap Dialog -->
	<link rel="stylesheet" href="<?php echo PUBLIC_DIR?>/css/bootstrap-dialog.css">
	<script src="<?php echo PUBLIC_DIR?>/js/bootstrap-dialog.js"></script>

	<!-- Jquery form validation -->
	<script type="text/javascript" src="<?php echo PUBLIC_DIR?>/js/jquery.validate.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_DIR?>/css/cmxform.css">

	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>

	<script>
		$(function(){
			var activeTab = "<?php if (isset($model['activeTab'])) echo $model['activeTab'] ?>";
			if (activeTab == "home"){
				$("#home-nav").addClass("active");
			} else if (activeTab == "search"){
				$("#search-nav").addClass("active");
			} else if (activeTab == "booking"){
				$("#my-booking-nav").addClass("active");
			} else if (activeTab == "contact"){
				$("#contact-nav").addClass("active");
			}

			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});

		});
	</script>

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div id="header">
					<ul class="nav nav-tabs">
						<li id="home-nav" role="presentation"><a href="<?php echo $router::createURL() ?>">Home</a></li>
						<li id="search-nav" role="presentation"><a href="<?php echo $router::createURL("flight", "search") ?>">Search Flight</a></li>
						<li id="my-booking-nav" role="presentation"><a href="<?php echo $router::createURL("booking") ?>">Your Bookings</a></li>
						<li id="contact-nav" role="presentation"><a href="<?php echo $router::createURL("home", "contact") ?>">Contact</a></li>
					</ul>
				</div>
				<br/>
				<div id="main">
					<?php 
						if ($controller != null)
							if (file_exists($controller->getViewFile()))
								require_once($controller->getViewFile());
							else {
								$controller->notFound();
								require_once($controller->getViewFile());
							}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>