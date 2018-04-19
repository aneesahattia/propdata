<?php
if (!isset($_SESSION['userId'])) {
    $sessionUrl = $_SERVER['REQUEST_URI'];
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">


                <?php if(isset($_REQUEST['loggedout']) && $_REQUEST['loggedout'] == "true") { echo '<div style="margin-top:40px;" class="alert alert-success">
                                You have been logged out.
                            </div>'; } ?>
                <?php if(isset($_REQUEST['error']) && $_REQUEST['error'] == "login incorrect") { echo '<div style="margin-top:40px;" class="alert alert-danger">
                                Your email and/or password did not match. Please try again.
                            </div>'; } ?>


                <div class="login-panel panel panel-default">
                    <script type="text/javascript">
                        function checkLogin() {
                            if (jQuery("#uemail").val() == "") {
                                alert ("Please complete all fields to login.");
                                return false;
                            }
                            if (jQuery("#upassword").val() == "") {
                                alert ("Please complete all fields to login.");
                                return false;
                            }
                            return true;
                        }
                    </script>
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo HTTP;?>login.php" method="post" onSubmit="return checkLogin();">
                            <input type="hidden" name="sessionUrl" value="<?php echo $sessionUrl;?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" id="uemail" name="uemail" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="upassword" name="upassword" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } else { ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
            <?php
                echo 'Logged in as<br/><a href="'.HTTP.'users/user.php?">'.$_SESSION['firstname'].' '.$_SESSION['surname'].'</a><br/>';
                echo '<a href="'.HTTP.'users/user.php"><img title="View Full Profile: '.$_SESSION['firstname'].' '.$_SESSION['surname'].'" style="width:120px" src="'.HTTP.'uploads/';
                if ($_SESSION['profilePicture'] <> "") { echo $_SESSION['profilePicture']; } else { echo 'defaultprofilepicture.png'; }
                echo '"></a><br/>';
                echo '<a href="'.HTTP.'logout.php">Log Out</a>';
            ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>