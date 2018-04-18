<?php
/**
 * Registration Processing Script (enq.php)
 * 
 */

# =============================================
# SCRIPT SETTINGS
# =============================================

$website_name			= "HET TRAVELS AND TOURS";								// Name of the website
$to_email				= "rehaan@hettravel.co.za";					// Where to send the email to
$from_email				= "no-reply@hettravel.co.za";				// Where to send the email from 
$email_subject			= "Booking from website";				// The Subject of the email
$url					= "declaration.php";						// Where to go after the email ahs been sent
#$total					= $_POST['sum'];

$fields 				= array (									// List of fields and their "Labels"
							"name"	=> "Name",
							"country" => "Country",
                            "email" => "Email address",
							"hotel" => "Hotel",
							"check-in" => "Check-in",
							"check-out" => "Check-out",
							"comfort" => "Comfort",
							"adults" => "Adults",
							"rooms" => "Rooms",
							"children" => "Children",
							"message" => "Message",

							
						);

# =============================================
# Construct Email
# =============================================

$message = "There has been a new contact request on $website_name Website\n\n
Time of Request was " . date("D d F Y") . " at " . date("H:i A") . "\n\n";
foreach ($_POST as $var => $val){
	if (isset($fields[$var])){
		$message .= $fields[$var] . " : " . $val . "\n\r\n";
	}
}

$header = "From: $from_email ";

# =============================================
# Send Email
# =============================================

if ($total == '') {
	mail($to_email, $email_subject, $message, $header);
}

# =============================================
# Redirect
# =============================================

print "<script>window.location.replace('$url');</script>\n";

# =============================================
# THE END
# =============================================
?>