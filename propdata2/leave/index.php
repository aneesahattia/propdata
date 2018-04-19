<?php session_start(); ?>
<?php
$thistitle='Leave ::';
$where = '  ';
$sortBy= '';
include '../pagetop.php';
?>
<?php if (!isset($_SESSION['userId'])) { ?>
<?php include '../loginform.php'; ?>
<?php } else { ?>

<?php
    if (isset($_GET['sortBy']) && $_GET['sortBy'] <> "") {
        $sortBy = $_GET['sortBy'];
    }

    if (isset($_GET['fromDate']) && $_GET['fromDate'] <> "") {
        $fromDate = $_GET['fromDate'].' 00:00:00';
    } else {
        $fromDate = date('Y-m-d 00:00:00', strtotime("now -30 days") );
    }

    if (isset($_GET['toDate']) && $_GET['toDate'] <> "") {
        $toDate = $_GET['toDate'].' 23:59:59';
    } else {
        $toDate = date("Y-m-d 23:59:59");
    }

    if (isset($_GET['clientName']) && $_GET['clientName'] <> "" && $sortBy == "client") {
        $where .=" WHERE c.clientName = '".$_GET['clientName']."' ";
    }

    if (isset($_GET['timesheetUserId']) && $_GET['timesheetUserId'] <> "" && $sortBy == "user") {
        $where .=" WHERE t.timesheetUserId = '".$_GET['timesheetUserId']."' ";
    }

       $where .= " AND t.timeAdded between '".$fromDate."' and '".$toDate."'";


    if ($_GET['timesheetUserId'] && $_GET['timesheetUserId'] <> ""){
        $theusername = mysqli_query($conn,"SELECT concat(firstname,' ',surname) as sortuser from users where userId = '".$_GET['timesheetUserId']."' ");
        while ($theusernames = mysqli_fetch_array($theusername) ) {
            $sortuser = $theusernames['sortuser'];
        }
    }


    $result = mysqli_query($conn,"SELECT u.userId, concat(u.firstname,' ',u.surname) as thisUser, j.jobNo, c.clientId, c.clientName, p.projectId, p.projectName, j.jobSummary, tasks.taskName, t.timelogged, t.timeAdded, j.estimatedMinutes from jobs j
left join projects p on p.projectId = j.project
left join clients c on c.clientId = p.client
left join timesheets t on t.timesheetJobNo = j.jobNo
left join tasks tasks on tasks.taskId = t.timetask
inner join users u on u.userId = t.timesheetUserId
".$where."
order by timeAdded DESC");

?>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="<?php echo HTTP.'js/jquery-ui.js';?>"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                $( "#fromDate" ).datepicker();
                $( "#toDate" ).datepicker();
            });
        });
        function checkFields() {
            if (jQuery("#sortBy").val() == "") {
                alert ("Search either by Client or User");
                return false;
            }
            if (jQuery("#clientName").val() == "" && jQuery("#timesheetUserId").val() == "") {
                alert ("Search either by Client or User");
                return false;
            }
            return true;
        }
    </script>


    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Fire Tree Time Sheet <?php if ($sortBy == "client" && isset($_GET['clientName']) && $_GET['clientName'] <> "") { echo 'for '.$_GET['clientName']; } elseif ($sortBy == "user" && isset($_GET['timesheetUserId']) && $_GET['timesheetUserId'] <> "") { echo 'for '.$sortuser; } ?> from <?php echo date("d F Y",strtotime($fromDate));?> to <?php echo date("d F Y",strtotime($toDate)); ?></h1>
            </div>

            <?php if ($_SESSION['manager'] == "1" || $_SESSION['accountexec'] == "1") { ?>
                <div id="searchForm" style="width: 100%; margin:20px;clear: both">
                    <form method="get" action="index.php" onSubmit="return checkFields();formatDate('#fromDate');formatDate('#toDate');">


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


                        <div style="float:left;">

                            <script type="text/javascript">
                                function searchFilter() {
                                    if (jQuery("#sortBy").val() == "client")  {
                                        jQuery("#clientName").show();
                                        jQuery("#timesheetUserId").hide();
                                    } else if (jQuery("#sortBy").val() == "user")  {
                                        jQuery("#clientName").hide();
                                        jQuery("#timesheetUserId").show();
                                    }
                                }
                            </script>

                            <label>Search by Client<?php if ($_SESSION['manager'] == "1") { ?> or User<?php } ?></label>
                            <select name="sortBy" id="sortBy" onChange="searchFilter();">
                                <option value="">Select</option>
                                <option value="client">Client</option>
                                <?php if ($_SESSION['manager'] == "1") { ?>
                                    <option value="user">User</option>
                                <?php } ?>
                            </select>

                            <select name="clientName" id="clientName" style="display:none;padding-left:10px;">
                                <option value="">Client</option>
                                <?php
                                $theusername = mysqli_query($conn,"SELECT clientName from clients order by clientName ASC");
                                while ($theusernames = mysqli_fetch_array($theusername) ) {
                                    echo '<option value="'.$theusernames['clientName'].'"';
                                    if (isset($_GET['clientName']) && $_GET['clientName'] <> "") {
                                        if ($_GET['clientName'] == $theusernames['clientName']) {
                                            echo ' selected="selected" ';
                                        }
                                    }
                                    echo '>'.$theusernames['clientName'].'</option>';
                                }
                                ?>
                            </select>
                        <?php if ($_SESSION['manager'] == "1") { ?>
                            <select name="timesheetUserId" id="timesheetUserId" style="display:none;padding-left:10px;">
                                <option value="">User</option>
                                <?php
                                $theusername = mysqli_query($conn,"SELECT userId, concat(firstname,' ',surname) as userName from users where status='1' order by firstname ASC");
                                while ($theusernames = mysqli_fetch_array($theusername) ) {
                                    echo '<option value="'.$theusernames['userId'].'"';
                                    if (isset($_GET['timesheetUserId']) && $_GET['timesheetUserId'] <> "") {
                                        if ($_GET['timesheetUserId'] == $theusernames['userId']) {
                                            echo ' selected="selected" ';
                                        }
                                    }
                                    echo '>'.$theusernames['userName'].'</option>';
                                }
                                ?>
                            </select>
                        <?php } ?>

                            <div class="form-group">
                                <input onChange="formatDate('#fromDate');" placeholder="From Date" class="form-control" name="fromDate" id="fromDate" value="<?php echo str_replace(" 00:00:00","",$fromDate); ?>">
                                <input onChange="formatDate('#toDate');" placeholder="To Date" class="form-control" name="toDate" id="toDate" value="<?php echo str_replace(" 23:59:59","",$toDate); ?>">
                                <input type="submit" value="Search" class="btn-success btn-sm btn">
                            </div>
                        </div>
                    </form>
                    <br/>
                </div>
            <?php } ?>



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
                <th>Client / Project</th>
                <th>Summary</th>
                <th>User</th>
                <th>Date</th>
                <th>Task</th>
                <th style="text-align: center;">Time (mins)</th>
                <th style="text-align: center;">Original Estimate</th>
                <!--<th>Original Estimate (hours)</th>-->
            </tr>
            </thead>
            <tbody>
            <?php $oddeven = "odd";
            $totalminsspent = 0;
            $totalminsestimated = 0;
                while ($row = mysqli_fetch_array($result) ) {
            ?>
            <tr class="<?php echo $oddeven; ?> gradeX" onClick="window.location.href='<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>';">
                <td><a href="<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>">#<?php echo $row['jobNo']; ?></a></td>
                <td><a href="<?php echo HTTP.'clients/client.php?clientId='.$row['clientId']; ?>"><?php echo $row['clientName'];?></a> / <a href="<?php echo HTTP.'projects/project.php?projectId='.$row['projectId']; ?>"><?php echo $row['projectName'];?></a></td>
                <td><a href="<?php echo HTTP.'jobs/job.php?jobNo='.$row['jobNo']; ?>"><?php echo $row['jobSummary']; ?></a></td>
                <td><a href="<?php echo HTTP.'users/user.php?userId='.$row['userId'];?>"><?php echo $row['thisUser']; ?></a></td>
                <td><?php echo date("d F Y", strtotime($row['timeAdded'])); ?></td>
                <td><?php echo $row['taskName']; ?></td>
                <td style="text-align: center;"><?php echo $row['timelogged']; ?></td>
                <td style="text-align: center;"><?php echo $row['estimatedMinutes']; ?> (mins)</td>
            </tr>
            <?php
                    if ($oddeven == "odd") {
                        $oddeven = "even";
                    } else {
                        $oddeven = "odd";
                    }
                    $totalminsspent = $totalminsspent + $row['timelogged'];
                    $totalminsestimated = $totalminsestimated + $row['estimatedMinutes'];
                }
            ?>
            <?php if ($totalminsspent > 0) { ?>
                <tr>
                    <td colspan="6" style="text-align:right;"><strong>Total time spent: </strong></td>
                    <td style="text-align: center;"><strong><?php echo $totalminsspent; ?> (mins)</strong></td>
                    <td style="text-align: center;"><strong><?php echo $totalminsestimated; ?> (mins)</strong></td>
                </tr>
            <?php } ?>
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


<?php } ?>
<?php include '../pagebottom.php'; ?>
<?php if ($sortBy == "client") { ?>
    <script type="text/javascript">
        $(document).ready(function (){
            jQuery("#sortBy").val("client");
            searchFilter()
        });
    </script>
<?php } elseif ($sortBy == "user") { ?>
    <script type="text/javascript">
        $(document).ready(function (){
            jQuery("#sortBy").val("user");
            searchFilter()
        });
    </script>
<?php } ?>