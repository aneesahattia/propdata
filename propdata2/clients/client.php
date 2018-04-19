<?php session_start();
$thistitle='Client ::';
$success='';
if (!isset($_GET['userId'])) { $_GET['userId'] = $_SESSION['userId']; }
?>
<?php include('../pagetop.php');?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include('../loginform.php');?>
<?php } else { ?>

    <?php
        if (isset($_POST['clientId']) && isset($_POST['clientName']) && isset($_POST['clientTel']) && isset($_POST['clientEmail'])) {



            $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
            $temp = explode(".", $_FILES["newclientLogo"]["name"]);
            $extension = end($temp);

            if ((($_FILES["newclientLogo"]["type"] == "image/gif")
                    || ($_FILES["newclientLogo"]["type"] == "image/jpeg")
                    || ($_FILES["newclientLogo"]["type"] == "image/bmp")
                    || ($_FILES["newclientLogo"]["type"] == "image/jpg")
                    || ($_FILES["newclientLogo"]["type"] == "image/pjpeg")
                    || ($_FILES["newclientLogo"]["type"] == "image/x-png")
                    || ($_FILES["newclientLogo"]["type"] == "image/png"))
                && ($_FILES["newclientLogo"]["size"] < 10000000)
                && in_array($extension, $allowedExts))
            {
                if ($_FILES["newclientLogo"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["newclientLogo"]["error"] . "<br>";
                } else {
                    $_FILES["newclientLogo"]["name"] = date("YmdHis")."_".$_FILES["newclientLogo"]["name"];
                    /*echo "Upload: " . $_FILES["profilePicture"]["name"] . "<br>";
                    echo "Type: " . $_FILES["profilePicture"]["type"] . "<br>";
                    echo "Size: " . ($_FILES["profilePicture"]["size"] / 1024) . " kB<br>";
                    echo "Temp file: " . $_FILES["profilePicture"]["tmp_name"] . "<br>";*/
                    move_uploaded_file($_FILES["newclientLogo"]["tmp_name"], ROOT."uploads/".$_FILES["newclientLogo"]["name"]);
                }
            } else {
                //echo "Invalid filetype";
            }








            if (!isset($_FILES['newclientLogo']['name']) || $_FILES['newclientLogo']['name'] == "") {
                //no companyLogo edited
                $clientLogo = $_POST['clientLogo'];
            } else {
                $clientLogo = $_FILES['newclientLogo']['name'];
            }

            if (!mysqli_query($conn,"update clients set

                clientName = '".mysqli_real_escape_string($conn,$_POST['clientName'])."',
                clientTel = '".mysqli_real_escape_string($conn,$_POST['clientTel'])."',
                clientEmail = '".mysqli_real_escape_string($conn,$_POST['clientEmail'])."',
                clientFax = '".mysqli_real_escape_string($conn,$_POST['clientFax'])."',
                clientAddress = '".mysqli_real_escape_string($conn,strip_tags($_POST['clientAddress']))."',
                clientUrl = '".mysqli_real_escape_string($conn,$_POST['clientUrl'])."',
                clientLogo = '".$clientLogo."',
                contact1Name = '".mysqli_real_escape_string($conn,$_POST['contact1Name'])."',
                contact1Tel = '".mysqli_real_escape_string($conn,$_POST['contact1Tel'])."',
                contact1Email = '".mysqli_real_escape_string($conn,$_POST['contact1Email'])."',
                contact1Mobile = '".mysqli_real_escape_string($conn,$_POST['contact1Mobile'])."',
                contact2Name = '".mysqli_real_escape_string($conn,$_POST['contact2Name'])."',
                contact2Tel = '".mysqli_real_escape_string($conn,$_POST['contact2Tel'])."',
                contact2Email = '".mysqli_real_escape_string($conn,$_POST['contact2Email'])."',
                contact2Mobile = '".mysqli_real_escape_string($conn,$_POST['contact2Mobile'])."'
                WHERE clientId = '".$_POST['clientId']."'"
            )) {
                echo '<span class="errormsg">Error clientdetails: '.mysqli_error($conn).'</span>';
                $success=0;
            } else {
                $success=1;
            }
        }
    }

    $result = mysqli_query($conn,"SELECT c.* FROM clients c WHERE c.clientId = '".$_GET['clientId']."'");
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    if ($count > 0) {

        $clientId = $row['clientId'];
        $clientName = $row['clientName'];
        $clientTel = $row['clientTel'];
        $clientEmail = $row['clientEmail'];
        $clientFax = $row['clientFax'];
        $clientAddress = $row['clientAddress'];
        $clientUrl = $row['clientUrl'];
        $clientLogo = $row['clientLogo'];
        $contact1Name = $row['contact1Name'];
        $contact1Tel = $row['contact1Tel'];
        $contact1Email = $row['contact1Email'];
        $contact1Mobile = $row['contact1Mobile'];
        $contact2Name = $row['contact2Name'];
        $contact2Tel = $row['contact2Tel'];
        $contact2Email = $row['contact2Email'];
        $contact2Mobile = $row['contact2Mobile'];


        if ($row['clientLogo'] == "") {
            $clientLogo = 'defaultprofilepicture.png';
        } else {
            $clientLogo = $row['clientLogo'];
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
                <h1 class="page-header"><?php echo $clientName;?></h1>
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
                            <a class="list-group-item" href="#"><i class="fa fa-certificate fa-fw"></i> Client Company Name<span class="pull-right text-muted1"><?php echo $clientName;?></span></a>
                            <a class="list-group-item" href="#"><i class="fa fa-phone fa-fw"></i> Telephone<span class="pull-right text-muted1"><?php echo $clientTel;?></span></a>
                            <a class="list-group-item" href="mailto:<?php echo $clientEmail;?>"><i class="fa fa-envelope fa-fw"></i> Email<span class="pull-right text-muted1"><?php echo $clientEmail;?></span></a>
                            <a class="list-group-item" href="#"><i class="fa fa-fax fa-fw"></i> Fax<span class="pull-right text-muted1"><?php echo $clientFax;?></span></a>
                            <a style="min-height:120px;" class="list-group-item" href="#"><i class="fa fa-home fa-fw"></i> Address<span style="text-align:right;" class="pull-right text-muted1"><?php echo nl2br($clientAddress);?></span></a>
                            <a class="list-group-item" target="_blank" href="<?php echo $clientUrl;?>"><i class="fa fa-laptop fa-fw"></i> URL<span class="pull-right text-muted1"><?php echo $clientUrl;?></span></a>
                            <a style="min-height:100px;" class="list-group-item" href="#"><i class="fa fa-user fa-fw"></i> Contact #1<span class="pull-right text-muted1"><?php echo $contact1Name;?></span><br/><span class="pull-right text-muted1"><?php echo $contact1Email;?></span><br/><span class="pull-right text-muted1"><?php echo $contact1Tel;?></span><br/><span class="pull-right text-muted1"><?php echo $contact1Mobile;?></span></a>
                            <a style="min-height:100px;" class="list-group-item" href="#"><i class="fa fa-user fa-fw"></i> Contact #2<span class="pull-right text-muted1"><?php echo $contact2Name;?></span><br/><span class="pull-right text-muted1"><?php echo $contact2Email;?></span><br/><span class="pull-right text-muted1"><?php echo $contact2Tel;?></span><br/><span class="pull-right text-muted1"><?php echo $contact2Mobile;?></span></a>
                            <a class="list-group-item" href="<?php echo HTTP.'projects/index.php?clientId='.$_GET['clientId'];?>"><i class="fa fa-briefcase fa-fw"></i> View All Jobs for <?php echo $clientName;?></a>

                        </div>
                        <!-- /.list-group -->
                        <?php if ($_SESSION['manager'] == "1") { ?>
                            <button class="btn btn-success btn-block" href="#" onclick="showEdit();jQuery('#saveNotification').fadeOut();">Edit Profile</button>
                        <?php } ?>
                    </div>
                    <!-- /.panel -->

                    <!-- /.panel -->

                    <!-- /.panel .chat-panel -->
                </div>
                <div class="col-lg-2">
                    <div class="list-group">
                        <img style="max-width:200px;max-height:200px;" src="<?php echo HTTP.'uploads/'.$clientLogo;?>">
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>



            <!--*************** EDIT PROFILE ***************-->
        <div id="editdiv" class="row" style="display:none;">
            <form action="client.php?clientId=<?php echo $clientId; ?>" method="POST" enctype="multipart/form-data" onSubmit="">
                <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">
                <input type="hidden" name="clientLogo" value="<?php echo $clientLogo; ?>">
                <div class="form-group">
                    <label>Client Company Name *</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                    <input placeholder="Client Name" class="form-control" name="clientName" id="clientName" value="<?php echo $row['clientName'];?>">
                </div>
                <div class="form-group">
                    <label>Telephone *</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Client Telephone" class="form-control" name="clientTel" id="clientTel" value="<?php echo $row['clientTel'];?>">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Client Email Address" class="form-control" name="clientEmail" id="clientEmail" value="<?php echo $row['clientEmail'];?>">
                </div>
                <div class="form-group">
                    <label>Fax</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Client Fax" class="form-control" name="clientFax" id="clientFax" value="<?php echo $row['clientFax'];?>">
                </div>
                <div class="form-group">
                    <label>Physical Address</label>
                    <br/><span class="small text-muted1" style="margin-bottom:5px;">Main business address or postal address.</span>
                    <textarea class="form-control" id="clientAddress" name="clientAddress"><?php echo $row['clientAddress'];?></textarea>
                </div>
                <div class="form-group">
                    <label>Website URL</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Client Url" class="form-control" name="clientUrl" id="clientUrl" value="<?php echo $row['clientUrl'];?>">
                </div>
                <div class="form-group">
                    <label>Company Logo</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input type="file" placeholder="Client Fax" class="" name="newclientLogo" id="newclientLogo">
                </div>
                <hr>
                <div class="form-group">
                    <label>Contact #1 Name</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #1 Name" class="form-control" name="contact1Name" id="contact1Name" value="<?php echo $row['contact1Name'];?>">
                </div>
                <div class="form-group">
                    <label>Contact #1 Email</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #1 Email" class="form-control" name="contact1Email" id="contact1Email" value="<?php echo $row['contact1Email'];?>">
                </div>
                <div class="form-group">
                    <label>Contact #1 Tel</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #1 Tel" class="form-control" name="contact1Tel" id="contact1Tel" value="<?php echo $row['contact1Tel'];?>">
                </div>
                <div class="form-group">
                    <label>Contact #1 Mobile</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #1 Mobile" class="form-control" name="contact1Mobile" id="contact1Mobile" value="<?php echo $row['contact1Mobile'];?>">
                </div>
                <hr>
                <div class="form-group">
                    <label>Contact #2 Name</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #2 Name" class="form-control" name="contact2Name" id="contact2Name" value="<?php echo $row['contact2Name'];?>">
                </div>
                <div class="form-group">
                    <label>Contact #2 Email</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #2 Email" class="form-control" name="contact2Email" id="contact2Email" value="<?php echo $row['contact2Email'];?>">
                </div>
                <div class="form-group">
                    <label>Contact #2 Tel</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #2 Tel" class="form-control" name="contact2Tel" id="contact2Tel" value="<?php echo $row['contact2Tel'];?>">
                </div>
                <div class="form-group">
                    <label>Contact #2 Mobile</label>
                    <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>-->
                    <input placeholder="Contact #2 Mobile" class="form-control" name="contact2Mobile" id="contact2Mobile" value="<?php echo $row['contact2Mobile'];?>">
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block" href="#" type="submit">Save Changes</button> <button class="btn btn-warning btn-block" href="#" type="button" onclick="showView();">Cancel</button>
                </div>
            </form>
        </div>

        <br/><a href="javascript:history.back()">Go Back</a>
        <br/><a href="<?php echo HTTP.'clients/index.php';?>">View All Clients</a>


    </div>
    <!-- /#page-wrapper -->

<?php include('../pagebottom.php');?>