<?php session_start(); ?>
<?php
$thistitle='Jobs ::';
$where = '  ';
$mainsearchwhere = '  ';
include '../pagetop.php';
?>
<?php if (!isset($_SESSION['userId'])) { ?>
<?php include '../loginform.php'; ?>
<?php } else { ?>

<?php
    if (isset($_GET['mainsearchwhere'])) {
        $mainsearchwhere .=" WHERE j.jobNo like '%".$_GET['mainsearchwhere']."%'";
        $mainsearchwhere .=" OR c.clientName like '%".$_GET['mainsearchwhere']."%'";
        $mainsearchwhere .=" OR concat(u2.firstname,' ',u2.surname) like '%".$_GET['mainsearchwhere']."%'";
        $mainsearchwhere .=" OR pr.priorityName like '%".$_GET['mainsearchwhere']."%'";
        $mainsearchwhere .=" OR jobSummary like '%".$_GET['mainsearchwhere']."%'";
        $mainsearchwhere .=" OR j.fullDescription like '%".$_GET['mainsearchwhere']."%'";
        $mainsearchwhere .=" OR p.projectName like '%".$_GET['mainsearchwhere']."%'";



    }
    if (isset($_GET['filterclient']) ||
        isset($_GET['filterstatus']) ||
        isset($_GET['filterassigned']) ||
        isset($_GET['filterae']) ||
        isset($_GET['filterpriority']) ||
        isset($_GET['filterprojectId'])
        ) {

        $where .=" WHERE j.jobNo <> '' ";

        $Filterclient = $_GET['filterclient'];
        $Filterae = $_GET['filterae'];
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


        $clientfilter .= " AND c.clientName IN (";
        foreach ($Filterclient as $Filterclient) {
            $clientfilter1 .= "'".str_replace('+','',$Filterclient)."',";
        }
        $clientfilter1 = rtrim($clientfilter1,',');
        $clientfilter .= $clientfilter1;
        $clientfilter .= ")";
        if ($clientfilter1 <> '' && $clientfilter1 <> "''") {
            $where .=$clientfilter;
        }





        $aefilter .= " AND j.accountExec IN  (";
        foreach ($Filterae as $Filterae) {
            $aefilter1 .= "'".str_replace('+','',$Filterae)."',";
        }
        $aefilter1 = rtrim($aefilter1,',');
        $aefilter .= $aefilter1;
        $aefilter .= ")";
        if ($aefilter1 <> '' && $aefilter1 <> "''") {
            $where .=$aefilter;
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
ORDER BY j.jobNo DESC");
?>

    <script src="<?php echo HTTP;?>js/jquery.sumoselect.min.js"></script>
    <link href="<?php echo HTTP;?>css/sumoselect.css" rel="stylesheet" />

    <script type="text/javascript">
        $(document).ready(function () {
            window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
            window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
        });
    </script>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Fire Tree Jobs</h1>
                <?php if (isset($_GET['mainsearchwhere'])) { ?>Search Results: <div style="margin-bottom:10px;" class="btn btn-black badge">You searched for: "<?php echo $_GET['mainsearchwhere'];?>"</div><?php } ?>


                <!-- FILTER -->
                <div class="panel panel-default" style="margin-left:0px;padding:5px;">

                    <button id="filtershow" onclick="jQuery('#filterform').slideToggle();jQuery('#filterhide').fadeIn();jQuery('#filtershow').hide();" style="display:none;padding:2px 10px;" class="btn btn-primary">Show Filter</button>
                    <button id="filterhide" style="padding:2px 10px;" onclick="jQuery('#filterform').slideToggle();jQuery('#filtershow').fadeIn();jQuery('#filterhide').hide();" class="btn btn-primary">Hide Filter</button>
                    <form action="index.php" method="get" id="filterform">

                        <div style="display:inline-block; height:20px;margin-top:20px;"> </div>
                        <select multiple="multiple" name="filterclient[]" placeholder="Clients" onchange="console.log($(this).children(':selected').length)" class="testsel">
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT clientName from clients order by clientName ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option ';
                                if (isset($_GET['filterclient'])) {
                                    if (in_array($crow['clientName'], $_GET['filterclient'])) {
                                        echo ' selected="selected" ';
                                    }
                                }
                                echo 'value="'.$crow['clientName'].'">'.$crow['clientName'].'</option>';
                            }
                            ?>
                        </select>
                        <div style="display:inline-block; height:20px"> &nbsp; </div>
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
                            $clientsresult = mysqli_query($conn,"SELECT concat(firstname,' ',surname) as myname, userId from users WHERE status='1' order by firstname ASC");
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
                            $clientsresult = mysqli_query($conn,"SELECT concat(firstname,' ',surname) as myname, userId from users WHERE status='1' order by firstname ASC");
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
                        <button class="btn-success btn" style="padding:2px 10px;" href="#" type="submit">Filter</button>
                        <button class="btn btn-warning" style="padding:2px 10px;" href="index.php">Reset</button>
                    </form>
                </div>
                <!-- FILTER END -->



                <?php  ?>
            </div>
            <!-- /.col-lg-12 -->
            <!-- /.row -->
            <div class="row">
            <div class="col-lg-12">
            <div class="panel panel-default">
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
                <th>Deadline</th>
                <!--<th>Original Estimate (hours)</th>-->
            </tr>
            </thead>
            <tbody>
            <?php $oddeven = "odd";
                while ($row = mysqli_fetch_array($result) ) {
            ?>
            <tr class="<?php echo $oddeven; ?> gradeX" onClick="window.location.href='<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>';">
                <td><a href="<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>">#<?php echo str_pad($row['jobNo'],6,"0",STR_PAD_LEFT); ?></a></td>
                <td><?php echo $row['clientName']; ?> <a href="<?php echo HTTP.'clients/client.php?clientId='.$row['clientId']; ?>"><img style="float:right;" src="<?php echo HTTP.'images/stock_view-details.png';?>"/></a></td>
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
                <!--<td><?php echo $row['estimatedMinutes']; ?></td>-->
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
            <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.row -->



    </div>
    <!-- /#page-wrapper -->
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            //$('#jobstable').dataTable();
            var oTable = $('#jobstable').dataTable();
            oTable.fnSort( [ [0,'desc'] ] );
        });
    </script>

<?php } ?>
<?php include '../pagebottom.php'; ?>