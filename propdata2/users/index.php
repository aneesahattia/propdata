<?php session_start(); ?>
<?php
$thistitle='Users ::';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
<?php include '../loginform.php'; ?>
<?php } else { ?>

<?php
    $result = mysqli_query($conn,"SELECT u.*,
sum(IF(j1.jobstatus = 5, 1, 0)) AS AssignedcompletedJobs,
sum(IF(j1.jobstatus in (1,2,3,4,5), 1, 0)) AS AssignedallJobs
from users u
LEFT JOIN relationalJobUsers rj ON rj.userId = u.userId
left join jobs j1 on j1.jobNo = rj.jobNo
WHERE u.status='1'
group by u.userId
ORDER BY u.firstname ASC,u.surname ASC");
?>



    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Fire Tree Users</h1>
            </div>
            <!-- /.col-lg-12 -->
            <!-- /.row -->
            <div class="row">
            <div class="col-lg-12">
            <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="clientstable">
            <thead class="th-blue-header">
            <tr>
                <th>Picture</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Cell</th>
                <th>AE</th>
                <th>Jobs</th>
            </tr>
            </thead>
            <tbody>
            <?php $oddeven = "odd";
                while ($row = mysqli_fetch_array($result) ) {
            ?>
            <tr class="<?php echo $oddeven; ?> gradeX" onclick="window.location.href='<?php echo HTTP.'users/user.php?userId='.$row['userId']; ?>';">
                <td><a href="<?php echo HTTP.'users/user.php?userId='.$row['userId']; ?>"><img style="border-radius:5px;height:40px;" src="<?php echo HTTP.'uploads/'; ?><?php echo $row['profilePicture']; ?>"/></a></td>
                <td><a href="<?php echo HTTP.'users/user.php?userId='.$row['userId']; ?>"><?php echo $row['firstname']; ?> <?php echo $row['surname']; ?></a></td>
                <td><?php echo $row['designation']; ?></td>
                <td><a href="mailto:<?php echo $row['email'];?>"><?php echo $row['email']; ?></a></td>
                <td><?php echo $row['cell']; ?></td>
                <td><?php if ($row['accountexec'] == "1") { ?><a href="<?php echo HTTP.'jobs/index.php?filterae='.$row['userId']; ?>">Yes</a><?php } else { ?>No<?php } ?></td>
                <td><?php if ($row['designer'] == "1") { ?><a href="<?php echo HTTP.'jobs/index.php?filterassigned='.$row['userId']; ?>"><?php echo $row['AssignedcompletedJobs']; ?> / <?php echo $row['AssignedallJobs']; ?></a><?php } else { ?>-<?php } ?></td>
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
            $('#clientstable').dataTable();
        });
    </script>

<?php } ?>
<?php include '../pagebottom.php'; ?>