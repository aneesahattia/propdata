<?php session_start(); ?>
<?php include('pagetop.php');?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include('loginform.php');?>
<?php } else { ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-briefcase fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="medium">Open Jobs</div>
                            <div>Assigned to Me</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                        $result = mysqli_query($conn,"SELECT j.jobNo, c.clientName, j.jobSummary
                            FROM jobs j
                            LEFT JOIN projects p ON p.projectId = j.project
                            LEFT JOIN clients c ON c.clientId = p.client
                            LEFT JOIN relationalJobUsers rj ON rj.jobNo = j.jobNo
                            WHERE rj.userId in ('".$_SESSION['userId']."') AND j.jobstatus IN (1,2,3,4)
                            ORDER BY j.created DESC LIMIT 5");
                        while ($row = mysqli_fetch_array($result) ) {
                            echo '<div style="width:100%;cursor:pointer;" class="text-muted small" onclick="window.location.href=\''.HTTP.'jobs/job.php?jobNo='.$row['jobNo'].'\';"><div style="float: left; width:20%;">#'.$row['jobNo'].'</div><div style="float: left; width:80%;">'.$row['clientName'].' '.$row['jobSummary'].'</div></div>';
                            echo '<div style="float:left;width:100%;" class="small"><hr style="border-bottom:1px solid #ccc;margin:4px 0 4px 0!important;"></div>';
                        }
                    ?>
                </div>
                <a href="<?php echo HTTP.'jobs/index.php?filterassigned[]='.$_SESSION['userId'].'&filterstatus=open';?>">
                    <div class="panel-footer">
                        <span class="pull-left">View All Open Jobs Assigned to Me</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>





        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="medium">Open Jobs</div>
                            <div>Assigned to Everyone Else</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $result = mysqli_query($conn,"SELECT j.jobNo, concat(u.firstname,' ',u.surname) as thisUser, c.clientName, p.projectName, j.jobSummary
                        FROM jobs j
                        LEFT JOIN projects p ON p.projectId = j.project
                        LEFT JOIN clients c ON c.clientId = p.client
                        LEFT JOIN relationalJobUsers rj ON rj.jobNo = j.jobNo
                        LEFT JOIN users u ON u.userId = rj.userId
                        WHERE rj.userId <> '".$_SESSION['userId']."' AND j.jobstatus IN (1,2,3,4)
                        ORDER BY j.created DESC");
                    while ($row = mysqli_fetch_array($result) ) {
                        echo '<div style="float:left;width:100%;cursor:pointer;" class="text-muted small" onclick="window.location.href=\''.HTTP.'jobs/job.php?jobNo='.$row['jobNo'].'\';"><div style="float: left; width:20%;">#'.$row['jobNo'].'</div><div style="float: left; width:80%;">'.$row['thisUser'].': '.$row['clientName'].' '.$row['jobSummary'].'</div></div>';
                        echo '<div style="float:left;width:100%;" class="small"><hr style="border-bottom:1px solid #ccc;margin:4px 0 4px 0!important;"></div>';
                    }
                    ?>
                </div>
                <a href="<?php echo HTTP.'jobs/index.php?filterstatus=open';?>">
                    <div class="panel-footer">
                        <span class="pull-left">View All Open Jobs</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>







        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="medium">Studio</div>
                            <div>Jobs Closed this Month</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $result = mysqli_query($conn,"SELECT COUNT(u.userId) as theCount, CONCAT(u.firstname,' ',u.surname) AS thisUser FROM jobs j
                        LEFT JOIN relationalJobUsers rj ON rj.jobNo = j.jobNo
                        LEFT JOIN users u ON u.userId = rj.userId
                        WHERE
                        j.jobstatus = '5'
                        AND YEAR(j.updated) = YEAR(CURDATE()) AND MONTH(j.updated) = MONTH(CURDATE())
                        GROUP BY u.userId
                        ORDER BY COUNT(u.userId) DESC");
                    while ($row = mysqli_fetch_array($result) ) {
                        echo '<div style="float:left;width:100%;" class="text-muted small"><div style="float: left; width:20%;">'.$row['theCount'].'</div><div style="float: left; width:80%;">'.$row['thisUser'].'</div></div>';
                        echo '<div style="float:left;width:100%;" class="small"><hr style="border-bottom:1px solid #ccc;margin:4px 0 4px 0!important;"></div>';
                    }
                    ?>
                </div>
                <a href="<?php echo HTTP.'jobs/index.php';?>">
                    <div class="panel-footer">
                        <span class="pull-left">View All Jobs</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>














        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="medium">A/E's</div>
                            <div>Jobs Closed this Month</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $result = mysqli_query($conn,"SELECT COUNT(u.userId) as theCount, CONCAT(u.firstname,' ',u.surname) AS thisUser FROM jobs j
                        LEFT JOIN users u ON u.userId = j.accountExec
                        WHERE
                        j.jobstatus = '5'
                        AND YEAR(j.updated) = YEAR(CURDATE()) AND MONTH(j.updated) = MONTH(CURDATE())
                        GROUP BY u.userId
                        ORDER BY COUNT(u.userId) DESC");
                    while ($row = mysqli_fetch_array($result) ) {
                        echo '<div style="float:left;width:100%;" class="text-muted small"><div style="float: left; width:20%;">'.$row['theCount'].'</div><div style="float: left; width:80%;">'.$row['thisUser'].'</div></div>';
                        echo '<div style="float:left;width:100%;" class="small"><hr style="border-bottom:1px solid #ccc;margin:4px 0 4px 0!important;"></div>';
                    }
                    ?>
                </div>
                <a href="<?php echo HTTP.'jobs/index.php';?>">
                    <div class="panel-footer">
                        <span class="pull-left">View All Jobs</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>





    </div>
    <!-- /.row -->
</div>
    <!-- /#page-wrapper -->

    <?php } ?>
<?php include('pagebottom.php');?>