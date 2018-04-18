<!DOCTYPE html>

<html lang="en">

	<head>

		<title>Flights</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WELCOME TO HET TRAVEL AND TOURS !

We have amazing deals to offer.

Our mission is to offer the best service possible to all our Clients, be it corporate or leisure.">

    <meta name="keywords" content="travel,holiday,vacation,tours,international,national,flight,bookings,booking,hotel,accomodation, places, to, visit, resort, break, away, overseas, ">
		<meta charset="utf-8">

		<meta name="format-detection" content="telephone=no" />

		<link rel="icon" href="images/favicon.ico">

		<link rel="shortcut icon" href="images/favicon.ico" />

		<link rel="stylesheet" href="css/style.css">

		<script src="js/jquery.js"></script>

		<script src="js/jquery-migrate-1.2.1.js"></script>

		<script src="js/script.js"></script>

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

		<header id="menu">

		  <div class="container_12">

				<div class="grid_12">

					<div class="menu_block">

						<nav class="horizontal-nav full-width horizontalNav-notprocessed">

							<ul class="sf-menu">

								

								<?php include "menu7.php"?>

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

			<iframe id='travelstartIframe-d91bfb19-8c90-48ae-876e-de6aa2be5195' 
    frameBorder='0' 
    scrolling='no' 
    style='margin: 0px; padding: 0px; border: 0px; height: 0px;'>
</iframe> 
<script type='text/javascript' src='https://www.travelstart.co.za/resources/js/jquery.ba-postmessage.min.js'></script> 
<script type='text/javascript'> 
	// these variables can be configured 
	var travelstartIframeId = 'travelstartIframe-d91bfb19-8c90-48ae-876e-de6aa2be5195'; 
	var iframeUrl = 'https://www.travelstart.co.za'; 
	var logMessages = false; 
	var showBanners = false; 
	var affId = '202177'; 
	var affCampaign = ''; 
	var affCurrency = 'Default'; // ZAR / USD / NAD / ... 
	var height = '0px'; 
	var width = '100%'; 
	var language = ''; // ar / en / leave empty for user preference
 
	// do not change these 
	var iframe = $('#' + travelstartIframeId); 
	var iframeVersion = '10'; 
	var autoSearch = false; 
	var affiliateIdExist = false;
	var urlParams = {}; 
	var alreadyExist = []; 
	var iframeParams = []; 
	var cpySource = ''; 
	var match,
		pl = /\+/g,  
		search = /([^&=]+)=?([^&]*)/g,
		decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
		query  = window.location.search.substring(1);
	while (match = search.exec(query)){ 
		urlParams[decode(match[1])] = decode(match[2]); 
	}				 
	for (var key in urlParams){ 
		if (urlParams.hasOwnProperty(key)){ 
			if (key == 'search' && urlParams[key] == 'true'){ 
				autoSearch = true; 
			} 
			if(	key == 'affId' || key == 'affid' || key == 'aff_id'){ 
				affiliateIdExist = true ; 
			} 
			iframeParams.push(key + '=' + urlParams[key]); 
			alreadyExist.push(key); 
		}	 
	}		 
  	if(!('show_banners' in alreadyExist)){ 
		iframeParams.push('show_banners=' + showBanners); 
	}		 
	if(!('log' in alreadyExist)){ 
		iframeParams.push('log='  + logMessages); 
	}		 
	if(! affiliateIdExist){ 
		iframeParams.push('affId='  + affId); 
	}		 
	if(! affiliateIdExist){ 
		iframeParams.push('language='  + language); 
	}		 
	if(!('affCampaign' in alreadyExist)){ 
		iframeParams.push('affCampaign='  + affCampaign); 
	}		 
	if(cpySource !== '' && !('cpySource' in alreadyExist)){ 
		iframeParams.push('cpy_source='  + cpySource); 
	}		 
	if(!('utm_source' in alreadyExist)){ 
		iframeParams.push('utm_source=affiliate'); 
	}		 
	if(!('utm_medium' in alreadyExist)){ 
		iframeParams.push('utm_medium='  + affId); 
	}		 
	if(!('isiframe' in alreadyExist)){ 
		iframeParams.push('isiframe=true'); 
	}		 
	if(!('landing_page' in alreadyExist)){ 
		iframeParams.push('landing_page=false'); 
	}		 
	if (affCurrency.length == 3){ 
		iframeParams.push('currency=' + affCurrency); 
	} 
	if(!('iframeVersion' in alreadyExist)){ 
   	iframeParams.push('iframeVersion='  + iframeVersion);
	}		 
	if(!('host' in alreadyExist)){ 
		iframeParams.push('host=' + window.location.href.split('?')[0]); 
	}		 
	var newIframeUrl = iframeUrl + (autoSearch ? '/search-on-index?search=true' : '/search-on-index?search=false') + '&' + iframeParams.join('&'); 
	iframe.attr('src', newIframeUrl); 
	function setIframeSize(newWidth, newHeight){ 
		iframe.css('width', newWidth); 
		iframe.width(newWidth); 
		iframe.css('height', newHeight); 
		iframe.height(newHeight); 
	} 
	setIframeSize(width, height); 
	$.receiveMessage(function(e, host) {
                try {
                    if (typeof e.data !== "undefined") {
                        var dataElements = e.data.split('&');
                        if (dataElements) {                            
                            if (dataElements.length === 1) {
                                //Resize
                                setIframeSize(width, e.data + 'px');
                           } else {
                                // Set iframe Size
                                var height = dataElements[1].split('=');
                                setIframeSize(width, height[1]+'px');
                        
                                // Scroll to position
                                if (dataElements.length > 2) {
                                    var scrollTo = dataElements[2].split('=');
                                    if (scrollTo[1] !== 'none') {
                                        var iframeTop = iframe.position().top;
                                        if (scrollTo[1] == 'to-top') {
                                            window.scrollTo(0, iframeTop);
                                        } else {
                                            window.scrollTo(0, iframeTop+parseInt(scrollTo[1]));
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (err) {
                    window.console && console.log(err);
                }
            }, iframeUrl); 
</script>
		  </div>

		</div>

<!--==============================footer=================================-->

		<footer id="footer">

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