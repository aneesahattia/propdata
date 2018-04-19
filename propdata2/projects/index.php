<?php session_start(); ?>
<?php
$where='  ';
$showall = 0;
$thistitle='Projects ::';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
<?php include '../loginform.php'; ?>
<?php } else { ?>

<?php

    if (isset($_GET['userId']) && $_GET['userId'] <> "") {
        $where = " WHERE p.projectLead = '".$_GET['userId']."' OR  p.accountExec = '".$_GET['userId']."' ";
        $showall = 1;
    }
    if (isset($_GET['clientId']) && $_GET['clientId'] <> "") {
        $where = " WHERE p.client = '".$_GET['clientId']."' ";
        $showall = 1;
    }
    $result = mysqli_query($conn,"SELECT
	p.projectId,
	p.projectName,
	p.dateCreated,
	c.clientId,
	c.clientName,
	c.clientLogo,
	p.projectLead AS projectLeadId,
	concat(u2.firstname, ' ', u2.surname) AS projectLeadName,
	p.accountExec AS accountExecId,
	concat(u1.firstname, ' ', u1.surname) AS accountExecName,
	SUM(IF(j.jobstatus = 5, 1, 0)) AS completedJobs,
	SUM(

		IF (j.jobstatus IN(1, 2, 3, 4, 5), 1, 0)
	) AS allJobs
FROM
	projects p
LEFT JOIN clients c ON c.clientId = p.client
LEFT JOIN users u1 ON u1.userId = p.accountExec
LEFT JOIN users u2 ON u2.userId = p.projectLead
LEFT JOIN jobs j ON j.project = p.projectId
".$where."
GROUP BY
	p.projectId
ORDER BY
	p.dateCreated DESC");

?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Browse Fire Tree Projects</h1>
            </div>
            <!-- /.col-lg-12 -->
            <!-- /.row -->
            <div class="row">
            <div class="col-lg-12">
            <div class="panel panel-default">

<?php if ($showall == 1) { echo '<br/><a style="margin:10px;" href="index.php">Show All Projects</a>'; } ?>
            <form action="index.php" method="post"></form>
            <!-- /.panel-heading -->
            <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="projectstable">
            <thead class="th-blue-header">
            <tr>
                <th>Client</th>
                <th>Project</th>
                <th>Jobs</th>
                <th>Account Exec</th>
                <th>Lead Designer</th>
                <th>Date Created</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $oddeven = "odd";
                while ($row = mysqli_fetch_array($result) ) {
            ?>
            <tr class="<?php echo $oddeven; ?> gradeX" onclick="window.location.href='<?php echo HTTP.'projects/project.php?projectId='.$row['projectId']; ?>';">
                <td><?php echo $row['clientName'];?></td>
                <td><a href="<?php echo HTTP.'projects/project.php?projectId='.$row['projectId']; ?>"><?php echo $row['projectName'];?></a></td>
                <td class="center">
                    <a href="<?php echo HTTP.'jobs/index.php?filterprojectId[]='.$row['projectId']; ?>"><?php echo $row['completedJobs'];?> / <?php echo $row['allJobs'];?></a>
                    <?php
                    $jobresult = mysqli_query($conn,"SELECT jobNo from jobs where project = '".$row['projectId']."' order by jobNo Desc");
                    $jobCount = mysqli_num_rows($jobresult);
                    if ($jobCount > 0) {
                        echo '<span style="margin-left:10px;">&nbsp;</span>';
                        while ($job = mysqli_fetch_array($jobresult) ) {
                            echo '<a class="dblue small" href="'.HTTP.'jobs/job.php?jobNo='.$job['jobNo'].'">#'.$job['jobNo'].'</a> ';
                        }
                    }
                    ?>
                </td>
                <td><a href="<?php echo HTTP.'users/user.php?userId='.$row['accountExecId']; ?>"><?php echo $row['accountExecName'];?></a></td>
                <td class="center"><a href="<?php echo HTTP.'users/user.php?userId='.$row['projectLeadId']; ?>"><?php echo $row['projectLeadName'];?></a></td>
                <td class="center"><?php echo date("d F Y",strtotime($row['dateCreated']));?></td>
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
            $('#projectstable').dataTable();
        });
    </script>

<?php } ?>
<?php include '../pagebottom.php'; ?>