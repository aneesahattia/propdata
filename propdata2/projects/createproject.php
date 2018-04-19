<?php session_start(); ?>
<?php
$thistitle='Create Project ::';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include '../loginform.php'; ?>
<?php } else { ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create a New Project</h1>
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
        if (isset($_POST['client']) && isset($_POST['projectName']) && isset($_POST['projectLead']) && isset($_POST['accountExec'])) {
            if (!mysqli_query($conn,"INSERT INTO projects (
                    client,
                    projectName,
                    projectLead,
                    accountExec,
                    dateCreated
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['client'])."',
                    '".mysqli_real_escape_string($conn,$_POST['projectName'])."',
                    '".mysqli_real_escape_string($conn,$_POST['projectLead'])."',
                    '".mysqli_real_escape_string($conn,$_POST['accountExec'])."',
                    NOW()
                    )"
            )) {
                echo '<span class="errormsg">Error rcu: '.mysqli_error($conn).'</span>';
            } else {

                $newprojectId = mysqli_insert_id($conn);
        ?>
                <script type="text/javascript">
                    <!--
                    window.location = "project.php?projectId=<?php echo $newprojectId;?>";
                    //-->
                </script>
        <?php
            }
        } ?>
        <?php if ($completed == false) { ?>

            <div>
                <form action="createproject.php" method="post" enctype="multipart/form-data" ><!--onSubmit="return validateForm();"-->
                    <div class="form-group">
                        <label>Select Client *</label>
                        <select class="form-control" id="client" name="client">
                            <option value="">Select Client</option>
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT clientName, clientId from clients order by clientName ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option ';
                                if (isset($_GET['clientId']) && $_GET['clientId'] == $crow['clientId']) { echo ' selected="selected" '; }
                                echo 'value="'.$crow['clientId'].'">'.$crow['clientName'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name of Project *</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>
                        <input placeholder="Project Name" class="form-control" name="projectName" id="projectName">
                    </div>
                    <div class="form-group">
                        <label>Select Lead Designer / Developer *</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">You need to choose a project lead. This should be the person that will complete most of the design work for this project.</span>
                        <select class="form-control" id="projectLead" name="projectLead">
                            <option value="">Select Lead Designer / Dev</option>
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT userId, concat(firstname,' ',surname) as designer from users where designer='1' and status='1' order by firstname ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option value="'.$crow['userId'].'">'.$crow['designer'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Account Executive *</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">This is the person who will approve the job and/or report back to the client.</span>
                        <select class="form-control" id="accountExec" name="accountExec">
                            <option value="">Select Account Executive</option>
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT userId, concat(firstname,' ',surname) as ae from users where accountExec='1' and status='1' order by firstname ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option value="'.$crow['userId'].'">'.$crow['ae'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" href="#" type="submit">Create Project</button>
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