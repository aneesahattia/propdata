<?php session_start(); ?>
<?php
$thistitle='Project ::';
$where = '  ';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include '../loginform.php'; ?>
<?php } else { ?>
<div id="page-wrapper">
    <div class="row">

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
        }
        $completed = true;
    } ?>
    <?php
    if (isset($_POST['updateae']) && isset($_POST['updatelead'])) {
        if (!mysqli_query($conn,"UPDATE projects set projectLead = '".mysqli_real_escape_string($conn,$_POST['updatelead'])."',
                    accountExec = '".mysqli_real_escape_string($conn,$_POST['updateae'])."'
                    WHERE projectId = '".$_GET['projectId']."'"
        )) {
            echo 'Update failed.';
        }
    } ?>
        <?php if ($completed == false) { ?>

            <?php
            $clientsresult = mysqli_query($conn,"SELECT p.*,concat(u1.firstname,' ',u1.surname) as ae, u1.profilePicture as aePhoto, u2.profilePicture as leadPhoto, concat(u2.firstname,' ',u2.surname) as lead, c.clientName from projects p left join clients c on c.clientId = p.client left join users u1 on u1.userId = p.accountExec left join users u2 on u2.userId = p.projectLead where projectId = '".$_GET['projectId']."'");



            while ($crow = mysqli_fetch_array($clientsresult) ) {
            ?>

                <div class="col-lg-12">
                    <h1 class="page-header">Project: <?php echo $crow['clientName']." ".$crow['projectName'];?></h1>
                </div>

                <div>
                    <div style="display:<?php if (isset($_GET['newprojectAdded'])) { ?>inline-block;<?php } else { ?>none;<?php } ?>;" class="alert alert-success">Project added successfully</div><br/><br/>



                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTabssss">
                            <li class="active"><a data-toggle="tab" href="#summary">Project Summary</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#jobs">Jobs</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#timesheets">Timesheets</a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#reports">Reports</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="summary" class="tab-pane fade active in">
                                <h3>Welcome to your project!</h3>
                                <p>
                                    Everything you need to know about how your project is running is tracked on this page.<br/>
                                    As your project evolves, the information will be updated. Use the tabs above to navigate within your project.<br/>
                                    <br/>
                                    <div id="viewproject">
                                        Account Executive:<br/><img style="border-radius:5px;height:40px;" src="<?php echo HTTP.'uploads/'.$crow['aePhoto'];?>" alt="<?php echo $crow['ae'];?>" title="<?php echo $crow['ae'];?>"><br/><?php echo $crow['ae'];?><br/><br/>
                                        Lead Designer:<br/><img style="border-radius:5px;height:40px;" src="<?php echo HTTP.'uploads/'.$crow['leadPhoto'];?>" alt="<?php echo $crow['lead'];?>" title="<?php echo $crow['lead'];?>"><br/><?php echo $crow['lead'];?><br/><br/>
                                    <?php if ($_SESSION['manager'] == "1" || $_SESSION['userId'] == $crow['accountExec']) { ?>
                                        <br/><a href="#" onclick="jQuery('#editproject').fadeIn();jQuery('#viewproject').hide();">Edit</a><br/>
                                    <?php } ?>
                                    </div>
                                    <div id="editproject" style="display:none;">
                                        <form action="project.php?projectId=<?php echo $_GET['projectId'];?>" method="POST">
                                            Account Executive:
                                            <select name="updateae">
                                                <?php
                                                $clientsresult = mysqli_query($conn,"SELECT CONCAT(u1.firstname,' ',u1.surname) AS myname, u1.userId   FROM users u1 WHERE u1.status='1' and u1.accountexec='1' group by u1.userId ORDER BY u1.firstname ASC");
                                                while ($zrow = mysqli_fetch_array($clientsresult) ) {
                                                    echo '<option ';
                                                        if ($zrow['userId'] == $crow['accountExec']) {
                                                            echo ' selected="selected" ';
                                                        }
                                                    echo 'value="'.$zrow['userId'].'">'.$zrow['myname'].'</option>';
                                                }
                                                ?>
                                            </select><br/>
                                            Lead Designer: <select name="updatelead">
                                                <?php
                                                $clientsresult = mysqli_query($conn,"SELECT CONCAT(u1.firstname,' ',u1.surname) AS myname, u1.userId   FROM users u1 WHERE u1.status='1' and u1.designer='1' group by u1.userId ORDER BY u1.firstname ASC");
                                                while ($zrow = mysqli_fetch_array($clientsresult) ) {
                                                    echo '<option ';
                                                        if ($zrow['userId'] == $crow['projectLead']) {
                                                            echo ' selected="selected" ';
                                                        }
                                                    echo 'value="'.$zrow['userId'].'">'.$zrow['myname'].'</option>';
                                                }
                                                ?>
                                            </select><br/>
                                            <button type="submit" href="#">Save</button><br/>
                                        </form>
                                    </div>

                                    <?php
                                    $jobsresult = mysqli_query($conn,"SELECT j.* from jobs j where project = '".$crow['projectId']."'");
                                    $jobCount = mysqli_num_rows($jobsresult);
                                        if ($jobCount < 1) {
                                    ?>
                                        <br/>Get your project started<br/>
                                        Create your first job by clicking on the "Create Job" button.<br/>
                                        <br/>
                                        <div class="form-group">
                                            <button class="btn btn-success btn-lg" onclick="window.location.href='<?php echo HTTP.'jobs/createjob.php?projectId='.$crow['projectId'].'&clientId='.$crow['client'];?>';" type="button">Create Job</button>
                                        </div>
                                    <?php } ?>
                                </p>
                            </div>
                            <div id="jobs" class="tab-pane fade">
                                <h3>All Jobs for this Project</h3>
                                <?php


                if (isset($_GET['projectId'])
                ) {

                    $where .= " WHERE p.projectId IN ('".$crow['projectId']."') ";

                    $Filterpriority = $_GET['filterpriority'];
                    $Filterassigned = $_GET['filterassigned'];
                    $Filterstatus = $_GET['filterstatus'];
                    $FilterprojectId = $_GET['filterprojectId'];



                    $projectIdFilter .= " AND p.projectId IN (";
                    foreach ($FilterprojectId as $FilterprojectId) {
                        $projectIdFilter1 .= "'".str_replace('+','',$FilterprojectId)."',";
                    }
                    $projectIdFilter1 = rtrim($projectIdFilter1,',');
                    $projectIdFilter .= $projectIdFilter1;
                    $projectIdFilter .= ")";
                    if ($projectIdFilter1 <> '' && $projectIdFilter1 <> "''") {
                        $where .=$projectIdFilter;
                    }


                    $priorityNamefilter .= " AND pr.priorityName IN  (";
                    foreach ($Filterpriority as $Filterpriority) {
                        $priorityNamefilter1 .= "'".str_replace('+','',$Filterpriority)."',";
                    }
                    $priorityNamefilter1 = rtrim($priorityNamefilter1,',');
                    $priorityNamefilter .= $priorityNamefilter1;
                    $priorityNamefilter .= ")";
                    if ($priorityNamefilter1 <> '' && $priorityNamefilter1 <> "''") {
                        $where .=$priorityNamefilter;
                    }




                    $assignedfilter .= " AND ru.userId IN  (";
                    foreach ($Filterassigned as $Filterassigned) {
                        $assignedfilter1 .= "'".str_replace('+','',$Filterassigned)."',";
                    }
                    $assignedfilter1 = rtrim($assignedfilter1,',');
                    $assignedfilter .= $assignedfilter1;
                    $assignedfilter .= ")";
                    if ($assignedfilter1 <> '' && $assignedfilter1 <> "''") {
                        $where .=$assignedfilter;
                    }



                    if ($Filterstatus == "open") {
                        $where .= " AND js.statusName <> 'Completed' AND js.statusName <> 'Cancelled' ";
                    } else {
                        $statusfilter .= " AND js.statusName IN  (";
                        foreach ($Filterstatus as $Filterstatus) {
                            $statusfilter1 .= "'".str_replace('+','',$Filterstatus)."',";
                        }
                        $statusfilter1 = rtrim($statusfilter1,',');
                        $statusfilter .= $statusfilter1;
                        $statusfilter .= ")";
                        if ($statusfilter1 <> '' && $statusfilter1 <> "''") {
                            $where .=$statusfilter;
                        }
                    }
                }







                    $result = mysqli_query($conn,"SELECT j.jobNo, p.projectId, jobSummary, j.fullDescription, j.deadline, j.created,  j.accountExec, js.statusName, pr.priorityName, c.clientId, c.clientName, p.projectName, concat(u2.firstname,' ',u2.surname) as ae,
  GROUP_CONCAT(DISTINCT(ru.userId)) AS rjusers
from jobs j
left join users u2 on j.accountExec = u2.userId
left join projects p on j.project = p.projectId
left join clients c on p.client = c.clientId
left join priorities pr on pr.priorityId = j.priority
  RIGHT JOIN relationalJobUsers ru
    ON ru.jobNo = j.jobNo
left join jobstatuses js on js.statusId = j.jobstatus
".$where."
".$mainsearchwhere."
group by j.jobNo
ORDER BY j.jobNo ASC");

                                ?>
                                <!-- FILTER -->
                                <div class="panel panel-default" style="margin-left:0px;padding:5px;">

                                    <button id="filtershow" onclick="jQuery('#filterform').slideToggle();jQuery('#filterhide').fadeIn();jQuery('#filtershow').hide();" style="display:none;padding:2px 10px;" class="btn btn-primary">Show Filter</button>
                                    <button id="filterhide" style="padding:2px 10px;" onclick="jQuery('#filterform').slideToggle();jQuery('#filtershow').fadeIn();jQuery('#filterhide').hide();" class="btn btn-primary">Hide Filter</button>
                                    <form action="project.php" method="get" id="filterform">
                                        <input type="hidden" name="projectId" value="<?php echo $_GET['projectId'];?>">
                                        <input type="hidden" name="jobstab" value="1">
                                        <div style="display:inline-block; height:20px;margin-top:20px;"> </div>
                                        <select multiple="multiple" name="filterpriority[]" placeholder="Priority" onchange="console.log($(this).children(':selected').length)" class="testsel">
                                            <?php
                                            $clientsresult = mysqli_query($conn,"SELECT priorityName from priorities order by priorityId ASC");
                                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                echo '<option ';
                                                if (isset($_GET['filterpriority'])) {
                                                    if (in_array($crow['priorityName'], $_GET['filterpriority'])) {
                                                        echo ' selected="selected" ';
                                                    }
                                                }
                                                echo 'value="'.$crow['priorityName'].'">'.$crow['priorityName'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <div style="display:inline-block; height:20px"> &nbsp; </div>
                                        <select multiple="multiple" name="filterstatus[]" placeholder="Status" onchange="console.log($(this).children(':selected').length)" class="testsel">
                                            <?php
                                            $clientsresult = mysqli_query($conn,"SELECT statusName from jobstatuses order by statusName ASC");
                                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                echo '<option ';
                                                if (isset($_GET['filterstatus'])) {
                                                    if (in_array($crow['statusName'], $_GET['filterstatus'])) {
                                                        echo ' selected="selected" ';
                                                    }
                                                }
                                                echo 'value="'.$crow['statusName'].'">'.$crow['statusName'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <div style="display:inline-block; height:20px"> &nbsp; </div>
                                        <select multiple="multiple" name="filterassigned[]" placeholder="Assigned To" onchange="console.log($(this).children(':selected').length)" class="testsel">
                                            <?php
                                            $clientsresult = mysqli_query($conn,"SELECT CONCAT(u1.firstname,' ',u1.surname) AS myname, u1.userId FROM relationalJobUsers rj LEFT JOIN users u1 ON rj.userId = u1.userId LEFT JOIN jobs j on j.jobNo = rj.jobNo WHERE j.project='".$_GET['projectId']."' group by u1.userId ORDER BY u1.firstname ASC");
                                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                echo '<option ';
                                                if (isset($_GET['filterassigned'])) {
                                                    if (in_array($crow['userId'], $_GET['filterassigned'])) {
                                                        echo ' selected="selected" ';
                                                    }
                                                }
                                                echo 'value="'.$crow['userId'].'">'.$crow['myname'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <div style="display:inline-block; height:20px"> &nbsp; </div>
                                        <select multiple="multiple" name="filterae[]" placeholder="AE" onchange="console.log($(this).children(':selected').length)" class="testsel">
                                            <?php
                                            $clientsresult = mysqli_query($conn,"SELECT CONCAT(u1.firstname,' ',u1.surname) AS myname, u1.userId   FROM jobs j LEFT JOIN users u1 ON j.accountExec = u1.userId WHERE j.project='".$_GET['projectId']."' group by u1.userId ORDER BY u1.firstname ASC");
                                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                                echo '<option ';
                                                if (isset($_GET['filterae'])) {
                                                    if (in_array($crow['userId'], $_GET['filterae'])) {
                                                        echo ' selected="selected" ';
                                                    }
                                                }
                                                echo 'value="'.$crow['userId'].'">'.$crow['myname'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <!--<button class="btn btn-warning" style="padding:2px 10px;" href="#" type="button">Reset</button>--><button class="btn-success btn" style="padding:2px 10px;" href="#" type="submit">Filter</button>
                                    </form>
                                </div>
                                <!-- FILTER END -->


                                <script src="<?php echo HTTP;?>js/jquery.sumoselect.min.js"></script>
                                <link href="<?php echo HTTP;?>css/sumoselect.css" rel="stylesheet" />

                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
                                        window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
                                    });
                                </script>



                                <!--div class="row"-->
                                <div class="row panel panel-default" style="padding:5px;">

                                        <div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover" id="jobstable">
                                                        <thead class="th-blue-header">
                                                        <tr>
                                                            <th>Job No</th>
                                                            <th>Client</th>
                                                            <th>Summary</th>
                                                            <th>Designer(s)</th>
                                                            <th>AE</th>
                                                            <th>Priority</th>
                                                            <th>Status</th>
                                                            <th>Created</th>
                                                            <th>deadline</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $oddeven = "odd";
                                                        while ($row = mysqli_fetch_array($result) ) {
                                                            ?>
                                                            <tr class="<?php echo $oddeven; ?> gradeX">
                                                                <td><a href="<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>">#<?php echo str_pad($row['jobNo'],6,"0",STR_PAD_LEFT); ?></a></td>
                                                                <td><a href="<?php echo HTTP.'clients/client.php?clientId='.$row['clientId']; ?>"><?php echo $row['clientName']; ?></a></td>
                                                                <td><a href="<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>"><?php echo $row['jobSummary']; ?></a></td>


                                                                <td>
                                                                    <?php
                                                                    $assigneesresult = mysqli_query($conn,"select u.userId, u.firstname, u.surname, u.profilePicture, u.email from users u where u.userId in (".$row['rjusers'].")");
                                                                    while ($assrow = mysqli_fetch_array($assigneesresult) ) {
                                                                        $assfirstname = $assrow['firstname'];
                                                                        $asssurname = $assrow['surname'];
                                                                        $assuserId = $assrow['userId'];
                                                                        ?><a href="<?php echo HTTP.'users/user.php?userId='.$assuserId;?>"><?php echo $assfirstname.' '.$asssurname; ?></a><br/><?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><a href="<?php echo HTTP.'users/user.php?userId='.$row['accountExec'];?>"><?php echo $row['ae']; ?></a></td>
                                                                <td><span class="priority_<?php echo str_replace(' ','_',str_replace('!','',$row['priorityName'])); ?>"><?php echo $row['priorityName']; ?></span></td>
                                                                <td><span class="badge1 status_<?php echo str_replace(' ','_',$row['statusName']); ?>"><?php echo $row['statusName']; ?></span></td>
                                                                <td><?php echo $row['created']; ?></td>
                                                                <td><?php echo $row['deadline']; ?></td>
                                                            </tr>
                                                            <?php
                                                            if ($oddeven == "odd") {
                                                                $oddeven = "even";
                                                            } else {
                                                                $oddeven = "odd";
                                                            }
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
                                </div>
                                <!-- /.row -->









                            </div>

                            <div id="timesheets" class="tab-pane fade">
                                <h4>Timesheets for this Project</h4>
                                <?php include '../timesheets/plist.php'; ?>
                            </div>

                            <div id="reports" class="tab-pane fade">
                                <h4>Reports</h4>
                                <p>Coming Soon</p>
                            </div>
                        </div>
                    </div>











            </div>
            <?php
            }
            ?>
        <?php } ?>



    </div>
    <!-- /.row -->
</div>
    <script>
        $(document).ready(function() {
            $('#jobstable').dataTable();
            <?php if (isset($_GET['jobstab']) && $_GET['jobstab'] == "1") { ?>
                $('#myTabssss a[href="#jobs"]').trigger('click');
            <?php } ?>
        });
    </script>

    <!-- /#page-wrapper -->
<?php } ?>
<?php include '../pagebottom.php'; ?>