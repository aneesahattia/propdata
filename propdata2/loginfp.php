<?php
session_start();
include('pagetop.php');
?>

<?php if(isset($_REQUEST['loggedout']) && $_REQUEST['loggedout'] == "true") { echo 'You have been logged out<br/>'; } ?>
<?php if(isset($_REQUEST['error']) && $_REQUEST['error'] == "login incorrect") { echo 'Your email and/or password did not match. Please try again.<br/>'; } ?>

    <h1>LOGIN REQUIRED</h1>
    In order to continue, you must login.
    <form action="<?php echo HTTP;?>login.php" method="post" onSubmit="return checkLogin();" >
        <input type="text" placeholder="Email" id="uemail" name="uemail"></br>
        <input type="password" placeholder="Password" id="upassword" name="upassword"></br>
        <input type="hidden" name="locationredirect" value="<?php if(isset($_GET['location'])) { echo $_GET['location']; }?>">
        <input class="bluebutton" type="submit" value="Login" name="submit">
        <input onclick="window.location.href='<?php echo HTTP;?>forgotpassword.php'" class="bluebutton" type="button" value="Help">
    </form>
<?php
include ROOT .'pagebottom.php';
?>