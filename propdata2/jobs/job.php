<?php session_start();
$thistitle='Job ::';
$success='';
$newjobNo = str_pad($_GET['jobNo'],6,"0",STR_PAD_LEFT);
if (isset($_GET['print']) && $_GET['print']=="saved") {
    echo '<iframe width="1px" height="1px" frameborder="0" src="http://jobs.firetree.co.za/jobs/printed/Job No '.$_GET['jobNo'].'.doc"></iframe>';
}
if (!isset($_GET['userId'])) { $_GET['userId'] = $_SESSION['userId']; }
?>
<?php include('../pagetop.php');?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include('../loginform.php');?>
<?php } else { ?>
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="<?php echo HTTP.'js/jquery-ui.js';?>"></script>
    <script type="text/javascript">
        function showEdit() {
            jQuery("#editdiv").fadeIn();
            jQuery("#statusdiv").hide();
            jQuery("#viewdiv").hide();
        }

        function showView() {
            jQuery("#editdiv").hide();
            jQuery("#statusdiv").hide();
            jQuery("#viewdiv").fadeIn();
        }

        function showStatus() {
            jQuery("#editdiv").hide();
            jQuery("#viewdiv").hide();
            jQuery("#statusdiv").fadeIn();
        }

        $(function() {
            $( "#deadline1" ).datepicker();
        });
        $(document).ready(function() {
            $("#estimatedMinutes").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errestimatedMinutes").html("Enter number(s) only.").show().fadeOut(2000);
                    return false;
                }
            });
        });
    </script>
</head>
<?php
    foreach ($_POST['assignee'] as $assignee) {
    echo $assignee.'<Br/>';
    }
    //exit();
    if ($_SESSION['manager'] == "1" || $_POST['accountExec'] == $_SESSION['userId']) {
        if (isset($_POST['priority']) && isset($_POST['deadline']) && isset($_POST['assignee']) && isset($_POST['accountExec'])) {
            if (!mysqli_query($conn,"UPDATE jobs set
                    priority = '".mysqli_real_escape_string($conn,$_POST['priority'])."',
                    deadline = '".mysqli_real_escape_string($conn,$_POST['deadline'])."',
                    estimatedMinutes = '".mysqli_real_escape_string($conn,$_POST['estimatedMinutes'])."',
                    accountExec = '".mysqli_real_escape_string($conn,$_POST['accountExec'])."',
                    jobstatus = '".mysqli_real_escape_string($conn,$_POST['jobstatus'])."',
                    updated = NOW()
                    WHERE jobNo = '".mysqli_real_escape_string($conn,$_GET['jobNo'])."'"
            )) {
                echo '<span class="errormsg">Error Updating Job: '.mysqli_error($conn).'</span>';
                $success=0;
            } else {
                mysqli_query($conn,"DELETE from relationalJobUsers where jobNo = '".$_GET['jobNo']."'");
                foreach ($_POST['assignee'] as $assignee) {
                    if (!mysqli_query($conn,"INSERT INTO relationalJobUsers (userId, jobNo) VALUES ('".$assignee."','".$_GET['jobNo']."')")) {
                        echo '<span class="errormsg">Error Assigning User: '.mysqli_error($conn).'</span>';
                        $success=0;
                    }
                }
                $success=1;
            }
        }
        if (isset($_POST['jobstatus'])) {
            if (!mysqli_query($conn,"UPDATE jobs set
                    jobstatus = '".mysqli_real_escape_string($conn,$_POST['jobstatus'])."'
                    WHERE jobNo = '".mysqli_real_escape_string($conn,$_GET['jobNo'])."'"
            )) {
                echo '<span class="errormsg">Error Updating Status: '.mysqli_error($conn).'</span>';
                $success=0;
            } else {
                $success=1;
            }

        }

        if ($success == 1) {
            foreach ($_POST['assignee'] as $assignee) {
                $result = mysqli_query($conn,"select firstname,email from users where userId = '".$assignee."'");
                while ($row = mysqli_fetch_array($result) ) {
                    $firstname = $row['firstname'];
                    $email = $row['email'];
                }
                //send to assignee
                $to = $email;
                $subject = 'Job #'.$newjobNo.' has been updated';

                $headers = "From: jobs@firetree.co.za\r\n";
                $headers .= "Reply-To: jobs@firetree.co.za\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $message = '<html><body>';
                $message = 'Hi '.$firstname.',<br/>
                                <br/>
                                Job details have been updated for Job #'.$newjobNo.'.<br/>
                                <br/>
                                <a href="http://jobs.firetree.co.za/jobs/job.php?jobNo='.$newjobNo.'">Click here to view the Job</a><br/>
                                <br/>
                                <a href="http://jobs.firetree.co.za">Jobs.FireTree.co.za</a>';
                $message .= '</body></html>';
                mail($to, $subject, $message, $headers);
            }


            $result = mysqli_query($conn,"select firstname,email from users where userId = '".$_POST['accountExec']."'");
            while ($row = mysqli_fetch_array($result) ) {
                $firstname = $row['firstname'];
                $email = $row['email'];
            }
            //send to ae
            $to = $email;
            $subject = 'Job #'.$newjobNo.' has been updated';

            $headers = "From: jobs@firetree.co.za\r\n";
            $headers .= "Reply-To: jobs@firetree.co.za\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = '<html><body>';
            $message = 'Hi '.$firstname.',<br/>
                            <br/>
                            Job details have been updated for Job #'.$newjobNo.'.<br/>
                            <br/>
                            <a href="http://jobs.firetree.co.za/jobs/job.php?jobNo='.$newjobNo.'">Click here to view the Job</a><br/>
                            <br/>
                            <a href="http://jobs.firetree.co.za">Jobs.FireTree.co.za</a>';
            $message .= '</body></html>';
            mail($to, $subject, $message, $headers);
        }
    }





    if ($_POST['assignee'] == $_SESSION['userId']) {

        if (isset($_POST['jobstatus'])) {
            if (!mysqli_query($conn,"UPDATE jobs set
                    jobstatus = '".mysqli_real_escape_string($conn,$_POST['jobstatus'])."'
                    WHERE jobNo = '".mysqli_real_escape_string($conn,$_GET['jobNo'])."'"
            )) {
                echo '<span class="errormsg">Error Updating Status: '.mysqli_error($conn).'</span>';
                $success=0;
            } else {
                $success=1;
                $result = mysqli_query($conn,"SELECT u1.firstname, u1.email FROM jobs jo LEFT JOIN relationalJobUsers rj on rj.jobNo = jo.jobNo LEFT JOIN users u1 ON u1.userId = rj.userId WHERE jo.jobNo = '".$_GET['jobNo']."' and rj.userId <> '".$_SESSION['userId']."'");
                while ($row = mysqli_fetch_array($result) ) {
                    $firstname = $row['firstname'];
                    $email = $row['email'];
                }
                //send to assignee
                $to = $email;
                $subject = 'Job #'.$newjobNo.' status has been updated';

                $headers = "From: jobs@firetree.co.za\r\n";
                $headers .= "Reply-To: jobs@firetree.co.za\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $message = '<html><body>';
                $message = 'Hi '.$firstname.',<br/>
                            <br/>
                            The status for Job #'.$newjobNo.' has been updated.<br/>
                            <br/>
                            <a href="http://jobs.firetree.co.za/jobs/job.php?jobNo='.$newjobNo.'">Click here to view the Job</a><br/>
                            <br/>
                            <a href="http://jobs.firetree.co.za">Jobs.FireTree.co.za</a>';
                $message .= '</body></html>';
                mail($to, $subject, $message, $headers);



            }

        }
    }


    $result = mysqli_query($conn,"SELECT j.jobstatus, j.jobNo, p.projectId, jobSummary, j.fullDescription, j.deadline, j.estimatedMinutes, j.created, p.projectLead, j.accountExec, js.statusName, pr.priorityName, c.clientId, c.clientName, p.projectName, rj.relationalJobUserId, u2.profilePicture as aePhoto, concat(u2.firstname,' ',u2.surname) as ae from jobs j
    left join users u2 on j.accountExec = u2.userId
    left join projects p on j.project = p.projectId
    left join clients c on p.client = c.clientId
    left join priorities pr on pr.priorityId = j.priority
    left join jobstatuses js on js.statusId = j.jobstatus
    LEFT JOIN relationalJobUsers rj ON rj.jobNo = j.jobNo
    WHERE j.jobNo = '".$_GET['jobNo']."'
    ORDER BY j.jobNo ASC");
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    if ($count > 0) {
        $jobNo = $row['jobNo'];
        $projectId = $row['projectId'];
        $jobSummary = $row['jobSummary'];
        $fullDescription = $row['fullDescription'];
        $deadline = $row['deadline'];
        $estimatedMinutes = $row['estimatedMinutes'];
        $created = $row['created'];
        $assignee = $row['projectLead'];
        $accountExec = $row['accountExec'];
        $statusName = $row['statusName'];
        $priorityName = $row['priorityName'];
        $clientId = $row['clientId'];
        $clientName = $row['clientName'];
        $projectName = $row['projectName'];
        $assignedPhoto = $row['assignedPhoto'];
        $aePhoto = $row['aePhoto'];
        $ae = $row['ae'];
        $jobstatus = $row['jobstatus'];
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

        <?php if ($success==1) {echo '<div style="margin-top:40px;" class="alert alert-success">Job successfully updated.</div>';} ?>
        
        <div class="col-lg-12">
            <a href="job_bag_front.php?jobNo=<?php echo $jobNo; ?>"><img src="<?php echo HTTP.'/images/printericon.png';?>" style="padding:5px;float:right;"></a>
            <h1 class="page-header">Job #<?php echo str_pad($jobNo,6,"0",STR_PAD_LEFT);echo ' - '; echo $jobSummary; ?> </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->





<!--*************** VIEW PROFILE ***************-->



    <div class="row">
        <div class="col-lg-7">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">




                    <div class="table-responsive">


                        <div style="padding-bottom:10px;margin-bottom:20px;">
                                <h2><a href="<?php echo HTTP.'clients/client.php?clientId='.$clientId;?>"><?php echo $clientName;?></a> | <a href="<?php echo HTTP.'projects/project.php?projectId='.$projectId;?>"><?php echo $projectName;?></a></h2>
                                <h2>Job #<?php echo str_pad($jobNo,6,"0",STR_PAD_LEFT);?> | <?php echo $jobSummary; ?></h2>








                                <div class="panel-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="myTabssss">
                                        <li class="active"><a data-toggle="tab" href="#details">Job Details</a>
                                        </li>
                                        <li class=""><a data-toggle="tab" href="#logtime">Log Time</a>
                                        </li>
                                        <li class=""><a data-toggle="tab" href="#timesheets">Timesheets</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div id="details" class="tab-pane fade active in">


                                            <div id="viewdiv">
                                                <?php if ($_SESSION['manager'] == "1" || $accountExec == $_SESSION['userId']) { ?>
                                                    <a href='#' onClick="showEdit();">Edit</a> | 
                                                <?php } ?>

                                                <?php
                                                $assigneesresult = mysqli_query($conn,"select u.userId from users u left join relationalJobUsers rj on rj.userId = u.userId where rj.jobNo = '".$jobNo."'");
                                                $assrow = mysqli_fetch_array($assigneesresult);
                                                ?>
                                                <?php if ($_SESSION['manager'] == "1" || $accountExec == $_SESSION['userId'] || in_array($_SESSION['userId'],$assrow)) { ?>
                                                    <a href='#' onClick="showStatus();">Change Status</a>
                                                <?php } ?>
                                                <br/><br/>
                                                <table class="table table-striped table-bordered table-hover" id="jobstable">
                                                    <!--<thead class="th-blue-header" style="background:#000000;">-->

                                                    <!--</thead>-->
                                                    <tbody>
                                                        <!--<tr class="<?php echo $oddeven; ?> gradeX" > -->
                                                    <tr>
                                                        <td style="width:186px;"><strong>Account Executive</strong></td>
                                                        <td><?php echo $ae;?> <?php echo '<img src="'.HTTP.'uploads/'.$aePhoto.'" height="40"/>';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Assigned to</strong></td>
                                                        <td>
                                                            <?php
                                                            $assigneesresult = mysqli_query($conn,"select u.userId, u.firstname, u.surname, u.profilePicture, u.email from users u left join relationalJobUsers rj on rj.userId = u.userId where rj.jobNo = '".$jobNo."'");
                                                            while ($assrow = mysqli_fetch_array($assigneesresult) ) {
                                                                $assfirstname = $assrow['firstname'];
                                                                $asssurname = $assrow['surname'];
                                                                $assprofilePicture = $assrow['profilePicture'];
                                                                $assemail = $assrow['email'];
                                                            echo $assfirstname.' '.$asssurname;
                                                            echo '<img src="'.HTTP.'uploads/'.$assprofilePicture.'" height="40"/><br/>';
                                                            }
                                                            ?>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Deadline</strong></td>
                                                        <td><?php echo date("d F Y",strtotime($deadline));?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Estimated Time in Minutes</strong></td>
                                                        <td><?php echo $estimatedMinutes;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td><span class="badge1 status_<?php echo str_replace(' ','_',$statusName); ?>"><?php echo $statusName; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Priority</strong></td>
                                                        <td><span class="priority_<?php echo str_replace(' ','_',str_replace('!','',$priorityName)); ?>"><?php echo $priorityName; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Description</strong></td>
                                                        <td><?php echo nl2br($fullDescription);?></td>
                                                    </tr>
                                                        <?php
                                                        if ($oddeven == "odd") {
                                                            $oddeven = "even";
                                                        } else {
                                                            $oddeven = "odd";
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>






                                            <div id="editdiv" style="display:none;">
                                                <div class="table-responsive">
                                                    <form action="job.php?jobNo=<?php echo $_GET['jobNo'];?>" method="POST">
                                                        <input type="hidden" name="dateFormat" value="yyyy-mm-dd">
                                                        <script type="text/javascript">
                                                            function isValidDate(dateString) {
                                                                var regEx = /^\d{4}-\d{2}-\d{2}$/;
                                                                return dateString.match(regEx) != null;
                                                            }
                                                            function formatDate(thisid){
                                                                if (!isValidDate(jQuery(thisid).val())) {
                                                                    jQuery( thisid ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                                                                }
                                                            }
                                                        </script>
                                                        <table class="table table-striped table-bordered table-hover" id="jobstable">
                                                            <!--<thead class="th-blue-header" style="background:#000000;">-->

                                                            <!--</thead>-->
                                                            <tbody>
                                                            <!--<tr class="<?php echo $oddeven; ?> gradeX" > -->
                                                            <tr>
                                                                <td style="width:186px;"><strong>Account Executive</strong></td>
                                                                <td>
                                                                    <select name="accountExec" placeholder="Account Exec">
                                                                        <?php
                                                                        $clientsresult = mysqli_query($conn,"SELECT concat(firstname,' ',surname) as myname, userId from users WHERE accountexec='1' AND status='1' order by firstname ASC");
                                                                        while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                                            echo '<option ';
                                                                            if ($accountExec == $crow['userId']) {
                                                                                echo ' selected="selected" ';
                                                                            }
                                                                            echo 'value="'.$crow['userId'].'">'.$crow['myname'].'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Assigned to</strong></td>
                                                                <td>
                                                                    <select multiple="multiple" name="assignee[]" placeholder="Assigned To">
                                                                        <?php
                                                                        $assigneesresult = mysqli_query($conn,"select u.userId from users u left join relationalJobUsers rj on rj.userId = u.userId where rj.jobNo = '".$jobNo."'");
                                                                        $assrow = mysqli_fetch_array($assigneesresult);

                                                                        $clientsresult = mysqli_query($conn,"SELECT concat(firstname,' ',surname) as myname, userId from users WHERE status='1' and designer='1' order by firstname ASC");
                                                                        while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                                            echo '<option ';
                                                                            if (in_array($crow['userId'],$assrow)) {
                                                                                echo ' selected="selected" ';
                                                                            }
                                                                            echo 'value="'.$crow['userId'].'">'.$crow['myname'].'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Deadline</strong></td>
                                                                <td><input onChange="formatDate('#deadline1');" placeholder="Deadline" class="form-control" name="deadline" id="deadline1" value="<?php echo date("Y-m-d",strtotime($deadline));?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Estimated Time in Minutes</strong></td>
                                                                <td><input placeholder="Estimated Minutes" class="form-control" name="estimatedMinutes" id="estimatedMinutes" value="<?php echo $estimatedMinutes;?>"><br/><span class="errmsg" id="errestimatedMinutes"></span></td>
                                                            </tr>


                                                            <tr>
                                                                <td><strong>Status</strong></td>
                                                                <td>
                                                                    <select name="jobstatus" placeholder="Status">
                                                                        <?php
                                                                        $clientsresult = mysqli_query($conn,"SELECT statusId, statusName from jobstatuses order by statusId ASC");
                                                                        while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                                            echo '<option ';
                                                                            if ($jobstatus == $crow['statusId']) {
                                                                                echo ' selected="selected" ';
                                                                            }
                                                                            echo 'value="'.$crow['statusId'].'">'.$crow['statusName'].'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Priority</strong></td>
                                                                <td>
                                                                    <select name="priority" placeholder="Priority">
                                                                        <?php
                                                                        $clientsresult = mysqli_query($conn,"SELECT priorityId, priorityName from priorities order by priorityId ASC");
                                                                        while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                                            echo '<option ';
                                                                            if ($priority == $crow['priorityId']) {
                                                                                echo ' selected="selected" ';
                                                                            }
                                                                            echo 'value="'.$crow['priorityId'].'">'.$crow['priorityName'].'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><button class="btn btn-success btn-block" href="#" type="submit">Save Changes</button> <button class="btn btn-warning btn-block" href="#" type="button" onclick="showView();">Cancel</button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if ($oddeven == "odd") {
                                                                $oddeven = "even";
                                                            } else {
                                                                $oddeven = "odd";
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <!-- /.table-responsive -->
                                            </div>

                                            <div id="statusdiv" style="display:none;">
                                                <div class="table-responsive">
                                                    <form action="job.php?jobNo=<?php echo $_GET['jobNo'];?>" method="POST">
                                                    <input type="hidden" name="assignee" value="<?php echo $_SESSION['userId'];?>">
                                                        <table class="table table-striped table-bordered table-hover" id="jobstable">
                                                            <!--<thead class="th-blue-header" style="background:#000000;">-->

                                                            <!--</thead>-->
                                                            <tbody>
                                                            <tr>
                                                                <td><strong>Status</strong></td>
                                                                <td>
                                                                    <select name="jobstatus" placeholder="Status">
                                                                        <?php
                                                                        if ($_SESSION['manager'] == "1" || $accountExec == $_SESSION['userId']) {
                                                                            $clientsresult = mysqli_query($conn,"SELECT statusId, statusName from jobstatuses order by statusId ASC");
                                                                        } else {
                                                                            $clientsresult = mysqli_query($conn,"SELECT statusId, statusName from jobstatuses where statusName not in ('Completed','Cancelled') order by statusId ASC");
                                                                        }
                                                                        while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                                            echo '<option ';
                                                                            if ($jobstatus == $crow['statusId']) {
                                                                                echo ' selected="selected" ';
                                                                            }
                                                                            echo 'value="'.$crow['statusId'].'">'.$crow['statusName'].'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><button class="btn btn-success btn-block" href="#" type="submit">Change Status</button> <button class="btn btn-warning btn-block" href="#" type="button" onclick="showView();">Cancel</button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if ($oddeven == "odd") {
                                                                $oddeven = "even";
                                                            } else {
                                                                $oddeven = "odd";
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                        </div>


                                        


                                        <div id="logtime" class="tab-pane fade">
                                            <!--<table class="table table-striped2 table-bordered table-hover2" id="jobstable">-->
                                            <table>
                                                <!--<thead class="th-blue-header" style="background:#000000;">-->

                                                <!--</thead>-->
                                                <tbody>
                                                <!--<tr class="<?php echo $oddeven; ?> gradeX" > -->
                                                <tr>
                                                    <td><strong>Log Your Time:</strong><br/>
                                                        <?php include '../timesheets/form.php';?></td>
                                                </tr>

                                                <?php
                                                if ($oddeven == "odd") {
                                                    $oddeven = "even";
                                                } else {
                                                    $oddeven = "odd";
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="timesheets" class="tab-pane fade">
                                            <!--<table class="table table-striped2 table-bordered table-hover2" id="jobstable">-->
                                            <table>
                                                <!--<thead class="th-blue-header" style="background:#000000;">-->

                                                <!--</thead>-->
                                                <tbody>
                                                <!--<tr class="<?php echo $oddeven; ?> gradeX" > -->

                                                <tr>
                                                    <td><strong>Time Logged:</strong><br/>
                                                        <?php include '../timesheets/list.php';?></td>
                                                </tr>

                                                <?php
                                                if ($oddeven == "odd") {
                                                    $oddeven = "even";
                                                } else {
                                                    $oddeven = "odd";
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>







                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            <!-- /.col-lg-12 -->




























                        </div>
        <!-- /.row -->
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <div style="border-bottom: 1px solid #ff8c00!important;margin-bottom:20px;">
                            <h2>Attachments</h2>
                        </div>
                        <table class="table table-striped2 table-bordered table-hover2" id="jobstable">
                            <!--<thead class="th-blue-header" style="background:#000000;">-->

                            <!--</thead>-->
                            <tbody>
                            <!--<tr class="<?php echo $oddeven; ?> gradeX" > -->

                            <tr>
                                <td><strong>Attachments:</strong><br/>
                                    <?php include '../attachments/list.php';?></td>
                            </tr>
                            <tr>
                                <td><strong>New Attachment:</strong><br/>
                                    <?php include '../attachments/attachment.php';?></td>
                            </tr>

                            <?php
                            if ($oddeven == "odd") {
                                $oddeven = "even";
                            } else {
                                $oddeven = "odd";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->


                    <div class="table-responsive">
                        <div style="border-bottom: 1px solid #ff8c00!important;margin-bottom:20px;">
                            <h2>Comments</h2>
                        </div>
                        <table class="table table-striped2 table-bordered table-hover2" id="jobstable">
                            <!--<thead class="th-blue-header" style="background:#000000;">-->

                            <!--</thead>-->
                            <tbody>
                            <!--<tr class="<?php echo $oddeven; ?> gradeX" > -->

                            <tr>
                                <td>
                                    <?php include '../comments/list.php';?></td>
                            </tr>
                            <tr>
                                <td><strong>Post New Comment:</strong><br/>
                                    <?php include '../comments/comment.php';?></td>
                            </tr>

                            <?php
                            if ($oddeven == "odd") {
                                $oddeven = "even";
                            } else {
                                $oddeven = "odd";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



<br/><a href="javascript:history.back()">Go Back</a>


    </div>
    <!-- /#page-wrapper -->

<?php } ?>
<?php include('../pagebottom.php');?>