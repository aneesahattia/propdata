<?php session_start(); ?>
<?php
$thistitle='Add a Client ::';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include '../loginform.php'; ?>
<?php } else { ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add a Client</h1>
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
        if (isset($_POST['clientName']) && isset($_POST['clientTel']) && isset($_POST['clientEmail'])) {




            $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
            $temp = explode(".", $_FILES["clientLogo"]["name"]);
            $extension = end($temp);

            if ((($_FILES["clientLogo"]["type"] == "image/gif")
                    || ($_FILES["clientLogo"]["type"] == "image/jpeg")
                    || ($_FILES["clientLogo"]["type"] == "image/bmp")
                    || ($_FILES["clientLogo"]["type"] == "image/jpg")
                    || ($_FILES["clientLogo"]["type"] == "image/pjpeg")
                    || ($_FILES["clientLogo"]["type"] == "image/x-png")
                    || ($_FILES["clientLogo"]["type"] == "image/png"))
                && ($_FILES["clientLogo"]["size"] < 10000000)
                && in_array($extension, $allowedExts))
            {
                if ($_FILES["clientLogo"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["clientLogo"]["error"] . "<br>";
                } else {
                    $_FILES["clientLogo"]["name"] = date("YmdHis")."_".$_FILES["clientLogo"]["name"];
                    /*echo "Upload: " . $_FILES["profilePicture"]["name"] . "<br>";
                    echo "Type: " . $_FILES["profilePicture"]["type"] . "<br>";
                    echo "Size: " . ($_FILES["profilePicture"]["size"] / 1024) . " kB<br>";
                    echo "Temp file: " . $_FILES["profilePicture"]["tmp_name"] . "<br>";*/
                    move_uploaded_file($_FILES["clientLogo"]["tmp_name"], ROOT."uploads/".$_FILES["clientLogo"]["name"]);
                }
            } else {
                //echo "Invalid filetype";
            }

            $clientLogo = $_FILES['clientLogo']['name'];




            if (!mysqli_query($conn,"INSERT INTO clients (
                    clientName,
                    clientTel,
                    clientEmail,
                    clientFax,
                    clientAddress,
                    clientUrl,
                    clientLogo,
                    contact1Name,
                    contact1Tel,
                    contact1Email,
                    contact1Mobile,
                    contact2Name,
                    contact2Tel,
                    contact2Email,
                    contact2Mobile
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['clientName'])."',
                    '".mysqli_real_escape_string($conn,$_POST['clientTel'])."',
                    '".mysqli_real_escape_string($conn,$_POST['clientEmail'])."',
                    '".mysqli_real_escape_string($conn,$_POST['clientFax'])."',
                    '".mysqli_real_escape_string($conn,strip_tags($_POST['clientAddress']))."',
                    '".mysqli_real_escape_string($conn,$_POST['clientUrl'])."',
                    '".$clientLogo."',
                    '".mysqli_real_escape_string($conn,$_POST['contact1Name'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact1Tel'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact1Email'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact1Mobile'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact2Name'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact2Tel'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact2Email'])."',
                    '".mysqli_real_escape_string($conn,$_POST['contact2Mobile'])."'
                    )"
            )) {
                echo '<span class="errormsg">Error creating client: '.mysqli_error($conn).'</span>';
            } else {

                $newclientId = mysqli_insert_id($conn);
        ?>
                <script type="text/javascript">
                    <!--
                    window.location = "client.php?clientId=<?php echo $newclientId;?>";
                    //-->
                </script>
        <?php
            }
        } ?>
        <?php if ($completed == false) { ?>

            <div>
                <form action="createclient.php" method="post" enctype="multipart/form-data" ><!--onSubmit="return validateForm();"-->
                    <div class="form-group">
                        <label>Client Company Name *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="Client Name" class="form-control" name="clientName" id="clientName">
                    </div>
                    <div class="form-group">
                        <label>Telephone *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Client Telephone" class="form-control" name="clientTel" id="clientTel">
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Client Email Address" class="form-control" name="clientEmail" id="clientEmail">
                    </div>
                    <div class="form-group">
                        <label>Fax</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Client Fax" class="form-control" name="clientFax" id="clientFax">
                    </div>
                    <div class="form-group">
                        <label>Physical Address</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">Main business address or postal address.</span>
                        <textarea class="form-control" id="clientAddress" name="clientAddress"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Website URL</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Client Url" class="form-control" name="clientUrl" id="clientUrl">
                    </div>
                    <div class="form-group">
                        <label>Company Logo</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input type="file" placeholder="Client Fax" class="" name="clientLogo" id="clientLogo">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Contact #1 Name</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #1 Name" class="form-control" name="contact1Name" id="contact1Name">
                    </div>
                    <div class="form-group">
                        <label>Contact #1 Email</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #1 Email" class="form-control" name="contact1Email" id="contact1Email">
                    </div>
                    <div class="form-group">
                        <label>Contact #1 Tel</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #1 Tel" class="form-control" name="contact1Tel" id="contact1Tel">
                    </div>
                    <div class="form-group">
                        <label>Contact #1 Mobile</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #1 Mobile" class="form-control" name="contact1Mobile" id="contact1Mobile">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Contact #2 Name</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #2 Name" class="form-control" name="contact2Name" id="contact2Name">
                    </div>
                    <div class="form-group">
                        <label>Contact #2 Email</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #2 Email" class="form-control" name="contact2Email" id="contact2Email">
                    </div>
                    <div class="form-group">
                        <label>Contact #2 Tel</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #2 Tel" class="form-control" name="contact2Tel" id="contact2Tel">
                    </div>
                    <div class="form-group">
                        <label>Contact #2 Mobile</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                        <input placeholder="Contact #2 Mobile" class="form-control" name="contact2Mobile" id="contact2Mobile">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" href="#" type="submit">Add Client</button>
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