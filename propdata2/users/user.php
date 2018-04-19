<?php session_start();
$thistitle='User ::';
$success='';
if (!isset($_GET['userId'])) { $_GET['userId'] = $_SESSION['userId']; }
?>
<?php include('../pagetop.php');?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include('../loginform.php');?>
<?php } else { ?>

<?php
    if ($_SESSION['userId'] == $_GET['userId'] || $_SESSION['manager'] == "1") {
    if (isset($_POST['designation']) && isset($_POST['email']) && isset($_POST['cell']) && isset($_POST['userId'])) {










        $upload = $_FILES["newprofilePicture"];
        $uploadPath = ROOT."uploads/";
        $uploadName = pathinfo($_FILES["newprofilePicture"]['name'], PATHINFO_FILENAME);
        $restrainedQuality = 75; //0 = lowest, 100 = highest. ~75 = default
        $sizeLimit = 200;
        $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
        $temp = explode(".", $_FILES["newprofilePicture"]["name"]);
        $extension = end($temp);

        if ((($_FILES["newprofilePicture"]["type"] == "image/gif")
                || ($_FILES["newprofilePicture"]["type"] == "image/jpeg")
                || ($_FILES["newprofilePicture"]["type"] == "image/bmp")
                || ($_FILES["newprofilePicture"]["type"] == "image/jpg")
                || ($_FILES["newprofilePicture"]["type"] == "image/pjpeg")
                || ($_FILES["newprofilePicture"]["type"] == "image/x-png")
                || ($_FILES["newprofilePicture"]["type"] == "image/png"))
            && in_array($extension, $allowedExts))
        {
            if ($_FILES["newprofilePicture"]["error"] > 0) {
                echo "Return Code: " . $_FILES["newprofilePicture"]["error"] . "<br>";
            } else {
                $_FILES["newprofilePicture"]["name"] = date("YmdHis")."_".$_FILES["newprofilePicture"]["name"];


                if($_FILES["newprofilePicture"]['size'] > $sizeLimit) {
                    //open a stream for the uploaded image
                    $streamHandle = @fopen($_FILES["newprofilePicture"]['tmp_name'], 'r');
                    //create a image resource from the contents of the uploaded image
                    $resource = imagecreatefromstring(stream_get_contents($streamHandle));

                    if(!$resource)
                        die('Something wrong with the upload!');

                    //close our file stream
                    @fclose($streamHandle);

                    //move the uploaded file with a lesser quality
                    imagejpeg($resource, $uploadPath . date("YmdHis")."_".$uploadName . '.jpg', $restrainedQuality);
                    //delete the temporary upload
                    @unlink($upload['tmp_name']);
                } else {
                    move_uploaded_file($_FILES["newprofilePicture"]["tmp_name"], ROOT."uploads/".$_FILES["newprofilePicture"]["name"]);
                }
            }
        } else {
            //echo "Invalid filetype";
        }









        if (!isset($_FILES['newprofilePicture']['name']) || $_FILES['newprofilePicture']['name'] == "") {
            //no companyLogo edited
            $profilePicture = $_POST['profilePicture'];
        } else {





            $photo = ROOT."uploads/".$_FILES["newprofilePicture"]["name"];
            // Get the image info from the photo
            $image_info = getimagesize($photo);
            $width = $new_width = $image_info[0];
            $height = $new_height = $image_info[1];
            $type = $image_info[2];

            // Load the image
                        switch ($type)
                        {
                            case IMAGETYPE_JPEG:
                                $image = imagecreatefromjpeg($photo);
                                break;
                            case IMAGETYPE_GIF:
                                $image = imagecreatefromgif($photo);
                                break;
                            case IMAGETYPE_PNG:
                                $image = imagecreatefrompng($photo);
                                break;
                            default:
                                die('Error loading '.$photo.' - File type '.$type.' not supported');
                        }

            // Create a new, resized image
                        $new_width = 200;
                        $new_height = $height / ($width / $new_width);
                        $new_image = imagecreatetruecolor($new_width, $new_height);
                        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            // Save the new image over the top of the original photo
            switch ($type)
            {
                case IMAGETYPE_JPEG:
                    imagejpeg($new_image, $photo, 100);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($new_image, $photo);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($new_image, $photo);
                    break;
                default:
                    die('Error saving image: '.$photo);
            }
            $profilePicture = $_FILES['newprofilePicture']['name'];
        }


    if (isset($_POST['newpassword']) && $_POST['newpassword'] <> "" && isset($_POST['repeatpassword']) && $_POST['repeatpassword'] <> "" && $_POST['newpassword'] == $_POST['repeatpassword']) {
        if (!mysqli_query($conn,"update users set
                    password = md5('".mysqli_real_escape_string($conn,$_POST['newpassword'])."')
                    WHERE userId = '".$_POST['userId']."'"
        )) {
            echo '<span class="errormsg">Error updating password: '.mysqli_error($conn).'</span>';
            $success=0;
        } else {
            $success=1;
        }
    }
    

        if (!mysqli_query($conn,"update users set
                    email = '".mysqli_real_escape_string($conn,$_POST['email'])."',
                    cell = '".mysqli_real_escape_string($conn,$_POST['cell'])."',
                    designation = '".mysqli_real_escape_string($conn,$_POST['designation'])."',
                    birthday = '".mysqli_real_escape_string($conn,$_POST['birthday'])."',
                    birthmonth = '".mysqli_real_escape_string($conn,$_POST['birthmonth'])."',
                    designer = '".mysqli_real_escape_string($conn,$_POST['designer'])."',
                    manager = '".mysqli_real_escape_string($conn,$_POST['manager'])."',
                    accountexec = '".mysqli_real_escape_string($conn,$_POST['accountexec'])."',
                    profilePicture = '".$profilePicture."',
                    status = '".mysqli_real_escape_string($conn,$_POST['status'])."'
                    WHERE userId = '".$_POST['userId']."'"
        )) {
            echo '<span class="errormsg">Error userdetails: '.mysqli_error($conn).'</span>';
            $success=0;
        } else {
            $success=1;
        }
        if ($_SESSION['userId'] == $_POST['userId']) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['designation'] = $_POST['designation'];
            $_SESSION['cell'] = $_POST['cell'];
            $_SESSION['birthday'] = $_POST['birthday'];
            $_SESSION['birthmonth'] = $_POST['birthmonth'];
            $_SESSION['manager'] = $_POST['manager'];
            $_SESSION['designer'] = $_POST['designer'];
            $_SESSION['accountexec'] = $_POST['accountexec'];
            $_SESSION['profilePicture'] = $profilePicture;
        }

    }
}
if (isset($_GET['userId']) && $_GET['userId'] <> "") {
    $result = mysqli_query($conn,"SELECT u.* FROM users u WHERE u.userId = '".$_GET['userId']."'");
} else {
    $result = mysqli_query($conn,"SELECT u.* FROM users u WHERE u.userId = '".$_SESSION['userId']."'");
}
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    if ($count > 0) {
        $userId = $row['userId'];
        $firstname = $row['firstname'];
        $surname = $row['surname'];
        $email = $row['email'];
        $designation = $row['designation'];
        $cell = $row['cell'];
        $birthday = $row['birthday'];
        $birthmonth = $row['birthmonth'];
        $designer = $row['designer'];
        $manager = $row['manager'];
        $accountexec = $row['accountexec'];
        $status = $row['status'];

        if ($manager == "1") { $manager="Yes"; } else { $manager="No";}
        if ($designer == "1") { $designer="Yes"; } else { $designer="No";}
        if ($accountexec == "1") { $accountexec="Yes"; } else { $accountexec="No";}

        if ($row['profilePicture'] == "") {
            $profilePicture = 'defaultprofilepicture.png';
        } else {
            $profilePicture = $row['profilePicture'];
        }
    } else {
        echo '<div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">ERROR</h1>
                        You have selected an invalid link.
                    </div>
                    <!-- /.col-lg-12 -->
                </div>';
        exit();
    }
?>


    <div id="page-wrapper">

    <div class="row">

        <?php if ($success==1) {echo '<div style="margin-top:40px;" id="saveNotification" class="alert alert-success">Details successfully updated.</div>';} ?>
        
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $firstname.' '.$surname;?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


<script type="text/javascript">
    function showEdit() {
        jQuery("#editdiv").fadeIn();
        jQuery("#viewdiv").hide();
    }

    function showView() {
        jQuery("#editdiv").hide();
        jQuery("#viewdiv").fadeIn();
    }
</script>


<!--*************** VIEW PROFILE ***************-->
        <div id="viewdiv" class="row">

            <!-- /.col-lg-8 -->
            <div class="col-lg-6">
                <div class="panel panel-default">

                    <!-- /.panel-heading -->
                    <div class="list-group">
                        <a class="list-group-item" href="#"><i class="fa fa-certificate fa-fw"></i> Designation<span class="pull-right text-muted1"><?php echo $designation;?></span></a>
                        <a class="list-group-item" href="#">
                                <i class="fa fa-envelope fa-fw"></i> Email Address
                                    <span class="pull-right text-muted1"><?php echo $email;?></span>
                            </a>
                        <a class="list-group-item" href="#">
                                <i class="fa fa-phone fa-fw"></i> Cell
                                    <span class="pull-right text-muted1"><?php echo $cell;?></span>
                            </a>
                        <a class="list-group-item" href="#">
                                <i class="fa fa-phone fa-fw"></i> Birthday
                                    <span class="pull-right text-muted1"><?php echo $birthday.' '.date("F", mktime(0, 0, 0, $birthmonth, 10));?></span>
                            </a>
                        <a class="list-group-item" href="#">
                            <i class="fa fa-upload fa-fw"></i> Designer
                            <span class="pull-right text-muted1"><?php echo $designer;?></span>
                        </a>
                        <a class="list-group-item" href="#">
                            <i class="fa fa-upload fa-fw"></i> Manager
                            <span class="pull-right text-muted1"><?php echo $manager;?></span>
                        </a>
                        <a class="list-group-item" href="<?php if ($row['accountexec'] == "1") { echo HTTP.'jobs/index.php?filterae[]='.$row['userId']; } else { echo '#'; } ?>">
                            <i class="fa fa-asterisk fa-fw"></i> Account Executive
                            <span class="pull-right text-muted1"><?php if ($row['accountexec'] == "1") { echo 'Yes'; } else { echo 'No'; } ?></span>
                        </a>
                        <a class="list-group-item" href="<?php echo HTTP.'jobs/index.php?filterassigned[]='.$row['userId']; ?>">
                            <i class="fa fa-briefcase fa-fw"></i> Jobs assigned to <?php echo $firstname.' '.$surname;?>
                            <span class="pull-right text-muted1">Click Here</span>
                        </a>
                        <a class="list-group-item" href="#">
                            <i class="fa fa-user fa-fw"></i> User Status
                            <span class="pull-right text-muted1"><?php if ($row['status'] == "1") { echo 'Active User'; } else { echo 'Inactive'; }?></span>
                        </a>
                    </div>
                    <?php if ($_SESSION['userId'] == $_GET['userId'] || $_SESSION['manager'] == "1") { ?>
                        <!-- /.list-group -->
                        <button class="btn btn-success btn-block" href="#" onclick="showEdit();jQuery('#saveNotification').fadeOut();">Edit Profile</button>
                    <?php } ?>
                </div>
                <!-- /.panel -->

                <!-- /.panel -->

                <!-- /.panel .chat-panel -->
            </div>
            <div class="col-lg-2">
                <div class="list-group">
                    <img style="max-width:200px;max-height:200px;" src="<?php echo HTTP.'uploads/'.$profilePicture;?>">
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>



<!--*************** EDIT PROFILE ***************-->
        <div id="editdiv" class="row" style="display:none;">
            <form action="user.php?userId=<?php echo $userId; ?>" method="POST" enctype="multipart/form-data" onSubmit="">
                <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                <input type="hidden" name="profilePicture" value="<?php echo $profilePicture; ?>">

            <!-- /.col-lg-8 -->
            <div class="col-lg-6">
                <div class="panel panel-default">

                    <!-- /.panel-heading -->
                    <div class="list-group">
                        <p class="list-group-item" href="#">
                            <i class="fa fa-certificate fa-fw"></i> Designation
                            <span class="pull-right text-muted1"><input type="text" name="designation" id="designation" value="<?php echo $designation;?>"></span></p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-envelope fa-fw"></i> Email Address
                            <span class="pull-right text-muted1"><input type="text" name="email" id="email" value="<?php echo $email;?>"></span>
                        </p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-phone fa-fw"></i> Cell
                            <span class="pull-right text-muted1"><input type="text" name="cell" id="cell" value="<?php echo $cell;?>"></span>
                        </p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-phone fa-fw"></i> Birthday
                            <span class="pull-right text-muted1">


                            <select name="birthday" id="birthday">
                            <option value="">Day</option>
                            <?php for ($bd = 1;$bd < 32; $bd++) { ?>
                                <option <?php if ($bd==$birthday) {echo " selected='selected' ";} ?> value="<?php echo $bd; ?>"><?php echo $bd; ?></option>
                            <?php 
                            }
                            ?>
                            </select>
                            <select name="birthmonth" id="birthmonth">
                            <option value="">Month</option>
                            <?php for ($bm = 1;$bm < 13; $bm++) { ?>
                                <option <?php if ($bm==$birthmonth) {echo " selected='selected' ";} ?> value="<?php echo $bm; ?>"><?php echo date("F", mktime(0, 0, 0, $bm, 10)); ?></option>
                            <?php 
                            }
                            ?>
                            </select>



                            </span>
                        </p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-upload fa-fw"></i> Designer
                            <span class="pull-right text-muted1"><select name="designer" id="designer"><option <?php if ($designer=="No") {echo " selected='selected' ";} ?> value="0">No</option><option  <?php if ($designer=="Yes") {echo " selected='selected' ";} ?> value="1">Yes</option></select></span>
                        </p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-upload fa-fw"></i> Manager
                            <span class="pull-right text-muted1"><select name="manager" id="manager"><option <?php if ($manager=="No") {echo " selected='selected' ";} ?> value="0">No</option><option  <?php if ($manager=="Yes") {echo " selected='selected' ";} ?> value="1">Yes</option></select></span>
                        </p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-asterisk fa-fw"></i> Account Executive
                            <span class="pull-right text-muted1"><select name="accountexec" id="accountexec"><option <?php if ($accountexec=="No") {echo " selected='selected' ";} ?> value="0">No</option><option  <?php if ($accountexec=="Yes") {echo " selected='selected' ";} ?> value="1">Yes</option></select></span>
                        </p>
                        <p class="list-group-item" href="#">
                            <i class="fa fa-user fa-fw"></i> User Status
                            <span class="pull-right text-muted1"><select name="status" id="status"><option <?php if ($status=="0") {echo " selected='selected' ";} ?> value="0">Inactive</option><option  <?php if ($status=="1") {echo " selected='selected' ";} ?> value="1">Active</option></select></span>
                        </p>
                        <p class="list-group-item" href="#" id="updatepassword">
                            <i class="fa fa-user fa-fw"></i> Update Password
                            <span class="pull-right text-muted1"><a id="newplink" href="#" onclick="jQuery('#updatepassword').css({'height':'100px'});jQuery('#updatepassworddiv').show();jQuery('#newplink').hide();jQuery('#newpassword').val('');jQuery('#repeatpassword').val('');">New Password</a><span id="updatepassworddiv" style="display: none;"><input placeholder="Enter new password" name="newpassword" id="newpassword" value="" type="password"><br><input placeholder="Repeat password" name="repeatpassword" id="repeatpassword" value="" type="password"><br><a href="#" onclick="jQuery('#updatepassworddiv').hide();jQuery('#newpassword').val('');jQuery('#repeatpassword').val('');jQuery('#newplink').show();jQuery('#updatepassword').css({'height':'auto'});">Cancel New Password</a></span></span>
                        </p>
                    </div>
                    <!-- /.list-group -->
                    <button class="btn btn-success btn-block" href="#" type="submit">Save Changes</button> <button class="btn btn-warning btn-block" href="#" type="button" onclick="showView();">Cancel</button>
                </div>
                <!-- /.panel -->

                <!-- /.panel -->

                <!-- /.panel .chat-panel -->
            </div>
            <div class="col-lg-2">
                <div class="list-group">
                    <img style="max-width:200px;max-height:200px;" src="<?php echo HTTP.'uploads/'.$profilePicture;?>">
                    <input type="file" name="newprofilePicture" id="newprofilePicture">
                </div>
            </div>
            </form>
            <!-- /.col-lg-4 -->
        </div>



        <br/><a href="javascript:history.back()">Go Back</a>
        <br/><a href="<?php echo HTTP.'users/index.php';?>">View All Users</a>


    </div>
    <!-- /#page-wrapper -->

<?php } ?>
<?php include('../pagebottom.php');?>