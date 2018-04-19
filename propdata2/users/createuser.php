<?php session_start(); ?>
<?php
$thistitle='Create User ::';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include '../loginform.php'; ?>
<?php } else { ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create a New User</h1>
        </div>


        <script type="text/javascript">
            function Checker( variable, errorvariable ){
                if (jQuery(variable).val() == ""){
                    jQuery(variable).removeClass("inputsuccess").addClass("inputerror");
                    jQuery(errorvariable).fadeIn();
                    jQuery(variable).focus();
                    isFalse = isFalse + 1;
                    alertmsg = "Please correct all highlighted fields.";
                } else {
                    jQuery(variable).removeClass("inputerror").addClass("inputsuccess");
                    jQuery(errorvariable).fadeOut();
                }
            }

            function validateForm() {
                isFalse = 0;
                Checker("#userId","#erroruserId");
                Checker("#leaveType","#errorleaveType");
                Checker("#startDate","#errorstartDate");
                Checker("#returnDate","#errorreturnDate");
                Checker("#totalWorkDays","#errortotalWorkDays");
                if (isFalse > 0) {
                    alert(alertmsg);
                    isFalse = 0;
                    return false;
                }
                isFalse = 0;
                return true;

            }

        </script>

    <?php
        if (isset($_POST['firstname']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {






            $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
            $temp = explode(".", $_FILES["profilePicture"]["name"]);
            $extension = end($temp);

            if ((($_FILES["profilePicture"]["type"] == "image/gif")
                    || ($_FILES["profilePicture"]["type"] == "image/jpeg")
                    || ($_FILES["profilePicture"]["type"] == "image/bmp")
                    || ($_FILES["profilePicture"]["type"] == "image/jpg")
                    || ($_FILES["profilePicture"]["type"] == "image/pjpeg")
                    || ($_FILES["profilePicture"]["type"] == "image/x-png")
                    || ($_FILES["profilePicture"]["type"] == "image/png"))
                && ($_FILES["profilePicture"]["size"] < 10000000)
                && in_array($extension, $allowedExts))
            {
                if ($_FILES["profilePicture"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["profilePicture"]["error"] . "<br>";
                } else {
                    $_FILES["profilePicture"]["name"] = date("YmdHis")."_".$_FILES["profilePicture"]["name"];
                    /*echo "Upload: " . $_FILES["profilePicture"]["name"] . "<br>";
                    echo "Type: " . $_FILES["profilePicture"]["type"] . "<br>";
                    echo "Size: " . ($_FILES["profilePicture"]["size"] / 1024) . " kB<br>";
                    echo "Temp file: " . $_FILES["profilePicture"]["tmp_name"] . "<br>";*/
                    move_uploaded_file($_FILES["profilePicture"]["tmp_name"], ROOT."uploads/".$_FILES["profilePicture"]["name"]);
                }
            } else {
                //echo "Invalid filetype";
            }

            $profilePicture = $_FILES['profilePicture']['name'];

            if ($profilePicture == "") {
                $profilePicture = 'defaultprofilepicture.png';
            }

            if (!mysqli_query($conn,"INSERT INTO users (
                    firstname,
                    surname,
                    email,
                    password,
                    cell,
                    birthday,
                    birthmonth,
                    profilePicture,
                    designation,
                    designer,
                    manager,
                    accountexec,
                    status
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['firstname'])."',
                    '".mysqli_real_escape_string($conn,$_POST['surname'])."',
                    '".mysqli_real_escape_string($conn,$_POST['email'])."',
                    MD5('".mysqli_real_escape_string($conn,$_POST['password'])."'),
                    '".mysqli_real_escape_string($conn,$_POST['cell'])."',
                    '".mysqli_real_escape_string($conn,$_POST['birthday'])."',
                    '".mysqli_real_escape_string($conn,$_POST['birthmonth'])."',
                    '".$profilePicture."',
                    '".mysqli_real_escape_string($conn,$_POST['designation'])."',
                    '".mysqli_real_escape_string($conn,$_POST['designer'])."',
                    '".mysqli_real_escape_string($conn,$_POST['manager'])."',
                    '".mysqli_real_escape_string($conn,$_POST['accountexec'])."',
                    '1'
                    )"
            )) {
                echo '<span class="errormsg">Error creating new user: '.mysqli_error($conn).'</span>';
            } else {

                $newuserId = mysqli_insert_id($conn);
        ?>
                <script type="text/javascript">
                    <!--
                    window.location = "user.php?userId=<?php echo $newuserId;?>";
                    //-->
                </script>
        <?php
            }
        } ?>
        <?php if ($completed == false) { ?>

            <div>
                <form action="createuser.php" method="post" enctype="multipart/form-data" ><!--onSubmit="return validateForm();"-->
                    <div class="form-group">
                        <label>First Name *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="First Name" class="form-control" name="firstname" id="firstname">
                    </div>
                    <div class="form-group">
                        <label>Surname *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="Surname" class="form-control" name="surname" id="surname">
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="Email Address" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label>Password *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="Password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label>Cell Number</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="Cell" class="form-control" name="cell" id="cell">
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <select name="birthday" id="birthday">
                            <option value="">Day</option>
                            <?php for ($bd = 1;$bd < 32; $bd++) { ?>
                                <option value="<?php echo $bd; ?>"><?php echo $bd; ?></option>
                            <?php 
                            }
                            ?>
                            </select>
                            <select name="birthmonth" id="birthmonth">
                            <option value="">Month</option>
                            <?php for ($bm = 1;$bm < 13; $bm++) { ?>
                                <option value="<?php echo $bm; ?>"><?php echo date("F", mktime(0, 0, 0, $bm, 10)); ?></option>
                            <?php 
                            }
                            ?>
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a job title for this user</span>
                        <input placeholder="Designation" class="form-control" name="designation" id="designation">
                    </div>
                    <div class="form-group">
                        <label>Is this user a Designer?</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <select class="form-control" id="designer" name="designer">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Is this user an Account Executive?</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <select class="form-control" id="accountexec" name="accountexec">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Does this user have Manager Privileges?</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <select class="form-control" id="manager" name="manager">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" href="#" type="submit">Create User</button>
                    </div>
                </form>
            </div>
        <?php } ?>



    </div>
    <!-- /.row -->
</div>
    <!-- /#page-wrapper -->
<?php } ?>
<?php include '../pagebottom.php'; ?>