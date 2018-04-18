<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Emailer</title>
</head>

<body>
<?php 
	if (isset($_GET['txtemail']))
	{
		$name = $_GET['txtname'];
		$email = $_GET['txtemail'];
		$subject = $_GET['txtsubject'];
		$message = $_GET['txtmsg'];
	}
	else
	{
	echo '<script type="text/javascript">alert("Error sending message"); setTimeout("window.location = \'index.php\', 1000");</script>';	
	}
?>

<?php
$from_addr = $email;
$to_addr = "rehaan@hettravel.co.za";
$body = "--Message from HET Travel and Tours Website --<br><br>" . $message;
$appbody = $body;
require_once("class.phpmailer.php"); 
$pMail = new PHPMailer(); 
$pMail->From     = $from_addr; 
$pMail->FromName = $from_addr; 
$pMail->IsSMTP(); 
$pMail->Host     = "mail.hettravel.co.za";       // replace with your smtp server 
$pMail->Username = "rehaan@hettravel.co.za";      // replace with your smtp username (if SMTPAuth is true) 
$pMail->Password = "Het123@reh";          // replace with your smtp password (if SMTPAuth is true) 
$pMail->SMTPAuth = false;                        // true/false - turn on/off smtp authentication 
$pMail->Subject = $subject; 
$pMail->Body    = $appbody; 
$pMail->AddAddress($to_addr); 
$pMail->IsHTML(true); 
$pMail ->Port=25;
$pMail->Send(); 
$pMail->ClearAddresses(); 
$pMail->ClearAttachments(); 
echo '<script type="text/javascript">alert("Message Sent"); setTimeout("window.location = \'index-4.php\', 1000");</script>';	
?>


</body>
</html>