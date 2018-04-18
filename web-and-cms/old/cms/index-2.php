<!DOCTYPE html>
<?php include('connect.php'); ?>

<html lang="en">

	<head>

		<title>Special Offers</title>

		<meta charset="utf-8">

		<meta name="format-detection" content="telephone=no" />

		<link rel="icon" href="../images/favicon.ico">

		<link rel="shortcut icon" href="../images/favicon.ico" />

		<link rel="stylesheet" href="../css/style.css">

		<script src="../js/jquery.js"></script>

		<script src="../js/jquery-migrate-1.2.1.js"></script>

		<script src="../js/script.js"></script>

		<script src="../js/superfish.js"></script>

		<script src="../js/jquery.ui.totop.js"></script>

		<script src="../js/jquery.equalheights.js"></script>

		<script src="../js/jquery.mobilemenu.js"></script>

		<script src="../js/jquery.easing.1.3.js"></script>

		<script>

		$(document).ready(function(){

			$().UItoTop({ easingType: 'easeOutQuart' });

			});

		</script>

		<!--[if lt IE 8]>

		<div style=' clear: both; text-align:center; position: relative;'>

			<a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">

				<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />

			</a>

		</div>

		<![endif]-->

		<!--[if lt IE 9]>

		<script src="js/html5shiv.js"></script>

		<link rel="stylesheet" media="screen" href="css/ie.css">

		<![endif]-->

	</head>

	<body>

<!--==============================header=================================-->

		<header>

			<div class="container_12">

				<div class="grid_12">

					<div class="menu_block">

						<nav class="horizontal-nav full-width horizontalNav-notprocessed">

							<ul class="sf-menu">

								<?php include ("../menu3.php");?>

							</ul>

						</nav>

						<div class="clear"></div>

					</div>

				</div>

				<div class="grid_12">

					<h1>

						<a href="index.html">

							<img src="../images/logo.png" alt="Your Happy Family">

						</a>

					</h1>

				</div>

			</div>

		</header>

<!--==============================Content=================================-->

		<div class="content"><div class="ic">HET Travels</div>

			<div class="container_12">

				<div class="grid_8">

					<h3>Special offers</h3>

					<?php

					#get all specials with that are available -sq;

					$sql = "SELECT * FROM `special_offers` where so_status=1 ORDER BY so_datetime DESC LIMIT 3";

					$fetch = $dbh->query($sql);

					while ($row = $fetch->fetch(PDO::FETCH_ASSOC)) {

						
					  	print "<div class='block2'>";
						
							print "<img src='/{$row['so_image_src']}' width='300' height='313' class='img_inner fleft'>";
							print "<div class='extra_wrapper'>";

							print "<div class='text1 col1'><a href='#'>{$row['so_title']}</a></div>";

							print "<p>";
							print  "{$row['so_desc']}</p>

							<p><p><a href=' http://www.booking.com/index.html?aid=395580' class='link1'>MAKE A BOOKING</a> </p></p>

								
										</div>
								</div>
							";
							
						}
						?>


<!--==============================footer=================================-->

		<footer>

	<?php include ("../footer.php");?>

		</footer>

		<script>

		$(function (){

			$('#bookingForm').bookingForm({

				ownerEmail: '#'

			});

		})

		</script>

	</body>

</html>