<!DOCTYPE html>

<html lang="en">

	<head>

		<title>Contacts</title>

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

								

								<?php include "menu6.php"?>

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

				<div class="grid_5">

					<h3>CONTACT INFO</h3>

				  <div class="map">We will get back to you as soon as possible ! 

				    <div class="clear"></div>

					<figure class="">

					  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3461.000893789663!2d30.988830315110185!3d-29.835395981958886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ef7074da25971bb%3A0x7165167787616ac!2s140+Moses+Kotane+Rd%2C+Sydenham%2C+Berea%2C+4091%2C+South+Africa!5e0!3m2!1sen!2s!4v1498629113279" allowfullscreen></iframe>

					  </figure>

					  <address>

						  <dl>

							  <dt>HET Travels<br>

							  </dt>

								<div></div>

                                <p>140 Moses Kotane Road, Overport, Ajmeri Manzil Building (Head Office)
                                <br>
                                Durban </p>
                               

							  <dd><span>Telephone:</span> 031 827 4453</dd>

							  <dd><span>Cellphone:</span> 083 783 1714 (Rehaan)</dd>

							  <dd><span>FAX:  </span>086 607 4506</dd>
						  </dl>
						  <p>&nbsp;</p>

					  </address>

					</div>

				</div>

				<div class="grid_6 prefix_1">

					<h3>GET IN TOUCH</h3>

					<form  class="form" action="mail.php" method="get" id="form"name = 'form' >

						<div class="success_wrapper">

							<div class="success-message">Contact form submitted</div>

						</div>

						<label class="name">

							<input type="text"id="txtname" name="txtname" placeholder="Name:" data-constraints="@Required @JustLetters" />

							<span class="empty-message">*This field is required.</span>

							<span class="error-message">*This is not a valid name.</span>

						</label>

						<label class="email">

							<input type="text" id="txtemail" name="txtemail"placeholder="Email:" data-constraints="@Required @Email" />

							<span class="empty-message">*This field is required.</span>

							<span class="error-message">*This is not a valid email.</span>

						</label>

						<label class="country">

							<input type="text" id="txtsubject" name="txtsubject" placeholder="Subject:" data-constraints="@Required @JustLetters"/>

							<span class="empty-message">*This field is required.</span>

							<span class="error-message">*This is invalid.</span>

						</label>

						<label class="message">

							<textarea id="txtmsg"name="txtmsg" placeholder="Message:" data-constraints='@Required @Length(min=20,max=999999)'></textarea>

							<span class="empty-message">*This field is required.</span>

							<span class="error-message">*The message is too short.</span>

						</label>

						<div>

							<div class="clear"></div>

							<div class="btns">

																<input type="button" onClick="checkform('mail.php','4','form')" value="Submit" name="submit" class="btn" />

							</div>

						</div>

					</form>

                    <span id = 'txtContents'></span>

                    

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