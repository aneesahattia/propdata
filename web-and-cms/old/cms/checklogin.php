<?php session_start();?>
<HTML>
<script src="js/checkform.js" type="text/javascript"></script>
<body>
<tr>
<td width="100%" height="100%" valign="top" align="center" border="0px">
<?php
$user=$_POST['txtusername'];
$pass=$_POST['txtuserpassword'];
$pass=base64_encode($pass);
include "connection.php5";
$sql = "SELECT username, password, rights from users where username = '".$user."' and password = '".$pass."'";
$rs = mysqli_query($con, $sql) or trigger_error(mysqli_error($con));
if (mysqli_num_rows($rs)==1)
{
	$row =mysqli_fetch_row($rs);
	$_SESSION['user'] = $user;
	$_SESSION['rights'] = $row[2];
	$_SESSION['LAST_ACTIVITY']=time();
	?>
       
<?php
	  if($_SESSION['rights']==0)
	  {
		  echo '<script type="text/javascript">setTimeout("window.location = \'add_new.php\', 1000");</script>';
	  }
	  
      ?> 
    <?php
}
else
{
	echo "<script type='text/javascript'>";
	echo 'alert 
	("Sorry, invalid username or password supplied. Call Aneesa");</script>';
	?>
	<!--<a href="login.php">click here</a> to go back and try again</b>-->
   
    <?php
}
?>
</td>
  </tr>
</table>
</body>
</HTML>