<!DOCTYPE html>
<html>
<head>
	<title>You booking detail from Online-Travel Agency</title>
</head>
<body>

	<div id="container">
		Dear <strong><?php echo "$personalDetail->firstName $personalDetail->lastName"?></strong>, <br/>
		Thank you for using our flight booking service. Below are your flight booking details:

		<div><h3>Your personal detail</h3></div>
		<div>
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

				if ($personalDetail->mobile != '')
					echo '<br/><strong>Mobile Phone: </strong>' . $personalDetail->mobile . "<br/>";

				if ($personalDetail->businessPhone != '')
					echo '<br/><strong>Business Phone: </strong>' . $personalDetail->businessPhone . "<br/>";

				if ($personalDetail->workPhone != '')
					echo '<br/><strong>Work Phone: </strong>' . $personalDetail->workPhone . "<br/>";
			?>
		</div>
		
		<hr/>

		<div>
		<?php 
			echo "<h3>Your booked flights</h3>";

			$i = 0;
			echo "<div style='width: 25%; min-width:300px'>";
			foreach ($bookedFlight as $flight){
				$i++;
				$flightDetail = $flight['flightDetail'];
				echo "<div style='background-color: #337ab7; border-color:#337ab7; color:#fff;
				border-top-left-radius: 3px; border-top-right-radius:3px; padding: 10px 15px; border-bottom: 1px solid transparent;'>";
				echo "Flight #$i: from <strong>{$flightDetail['from_city']}</strong> to <strong>{$flightDetail['to_city']}</strong><br/>";
				echo "</div>";

				echo "<div style='padding: 15px; border-color: #337ab7; border: 1px solid;
				border-bottom-left-radius: 3px; border-bottom-right-radius:3px;'>";
				echo "Price: <strong>\${$flightDetail['price']}</strong><br/>";
				$seatNo = 0;
				foreach($flight['seats'] as $seat){
					$seatNo++;
					$seatCondition = array();

					$seatDescription = "Normal seat";
					if (is_array($seat)){
						$seatDescription = "Special condition: ";
						if (isset($seat['child'])) $seatDescription .= "children + ";
						if (isset($seat['wheelchair'])) $seatDescription .= "wheelchair + ";
						if (isset($seat['diet'])) $seatDescription .= "special diet + ";
						$seatDescription = substr($seatDescription, 0, strlen($seatDescription)-2);
					}

					echo "<div>Seat #$seatNo: $seatDescription</div>";
				}

				echo "</div><br/>";
			}
			echo "</div>";
		?>
		</div>

		<br/>
		<div>Best Regards</div>
		<br/>
		<div>University of Technology, Sydney</div>
		<div>Internet Programming - 32516</div>
		<div>Cuu Son Dang - 12129565</div>
	</div>
</body>
</html>