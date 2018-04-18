<!DOCTYPE html>

<html lang="en">

<head>

		<title>Lounge Pass</title>

		<meta charset="utf-8">

		<meta name="format-detection" content="telephone=no" />

		<link rel="icon" href="images/favicon.ico">

		<link rel="shortcut icon" href="images/favicon.ico" />

		<link rel="stylesheet" href="css/form.css">

		<link rel="stylesheet" href="css/style.css">

		<script src="js/jquery.js"></script>

		<script src="js/jquery-migrate-1.2.1.js"></script>

		<script src="js/script.js"></script>

		<script src="js/TMForm.js"></script>

		<script src="js/superfish.js"></script>

		<script src="js/jquery.ui.totop.js"></script>

		<script src="js/jquery.equalheights.js"></script>

		<script src="js/jquery.mobilemenu.js"></script>

		<script src="js/jquery.easing.1.3.js"></script>

		<script>

		$(document).ready(function(){

			$().UItoTop({ easingType: 'easeOutQuart' });

			});

		</script>

        <script type='text/javascript'>

function checkform(pagelink,elements,formName) {//this one creates the page link passing all elements

	flag=true;

	for (i=0;i<elements;i++) {

		box = document.forms[formName].elements[i] 

		if (i==0)

		{

			pagelink=pagelink+"?"+box.name+'='+box.value;

		}

		else

		{

			pagelink=pagelink+'&'+box.name+'='+box.value;

		}

				if (!box.value) {

					alert(pagelink);

					alert('You haven\'t filled in ' + box.name + '!');

					box.focus();

					flag=false;

				}

	}

	if (flag) 

	{

			 document.getElementById("txtContents").innerHTML='Please wait, sending message';

		if (window.XMLHttpRequest)

		  {// code for IE7+, Firefox, Chrome, Opera, Safari

		  xmlhttp=new XMLHttpRequest();

		  }

		else

		  {// code for IE6, IE5

		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		  }

		xmlhttp.onreadystatechange=function()

		  {

		  if (xmlhttp.readyState==4 && xmlhttp.status==200)

			{

			document.getElementById("txtContents").innerHTML=xmlhttp.responseText;

			}

		  }

		xmlhttp.open("GET",pagelink,true);

		xmlhttp.send();

		document.getElementById("txtname").value="";

		document.getElementById("txtemail").value="";

		document.getElementById("txtsubject").value="";

		document.getElementById("txtmsg").value="";

	}//Flag

}



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

								

								<?php include "menu5.php"?>

							</ul>

						</nav>

						<div class="clear"></div>

					</div>

				</div>

				<div class="grid_12">

					<h1>

						<a href="index.html">

							<img src="images/logo.png" alt="Your Happy Family">

						</a>

					</h1>

				</div>

			</div>

		</header>

<!--==============================Content=================================-->

		<div class="content"><div class="ic">HET Travels</div>

			<div class="container_12">

				<div class="grid_12">

					<h3>Lounge Pass</h3>

				  <div class="map"><strong>Affordable VIP Indulgence</strong> – you are only 4 simple steps away from enjoying the comfort of an airport VIP lounge.<br>
                  VIP Lounges provide a tranquil environment where travellers can relax before they fly, where they can enjoy a quiet drink and light refreshments, read newspapers or simply watch TV. Lounge Pass is ideal for the leisure traveller who wants to add a touch of luxury to the start or end of their holiday. Travellers can swap the hustle and bustle of a busy airport terminal for the quiet and comfort of an airport VIP lounge before their flight. <br>

There are over 300 airport VIP lounges worldwide in the Lounge Pass programme – in 70 countries at over 190 airports including 26 in the UK. <br>
Many lounges welcome children and infants and in some cases access for them is free. 

				    <div class="clear"></div>

					<figure class="">

					<iframe id="lpframe" src="https://www.loungepass.com/tp/HET-102?isiframe=1" style="padding: 10px; width: 100%; height: 

800px; "></iframe>

					  </figure>

					  

				  </div>

				</div>

				

			</div>

		</div>

<!--==============================footer=================================-->

		<footer>

			<?php include "footer.php" ?>

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