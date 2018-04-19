<?php session_start(); ?>
<?php
$thistitle='Clients ::';
include '../pagetop.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
<?php include '../loginform.php'; ?>
<?php } else { ?>

<?php
    $result = mysqli_query($conn,"SELECT * from clients ORDER BY clientName ASC");
?>



    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Fire Tree Clients</h1>
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
                <th>Logo</th>
                <th>Client Name</th>
                <th>Tel</th>
                <th>Email</th>
                <th>Fax</th>
                <th>Contact #1</th>
                <th>Contact #1 Email</th>
                <th>Contact #1 Cell</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $oddeven = "odd";
                while ($row = mysqli_fetch_array($result) ) {
            ?>
            <tr class="<?php echo $oddeven; ?> gradeX">
                <td><a href="<?php echo HTTP.'clients/client.php?clientId='.$row['clientId']; ?>"><img style="max-width:40px;max-height: 40px;" src="<?php echo HTTP.'uploads/'; ?><?php echo $row['clientLogo']; ?>"/></a></td>
                <td><a href="<?php echo HTTP.'clients/client.php?clientId='.$row['clientId']; ?>"><?php echo $row['clientName'];?></a></td>
                <td><?php echo $row['clientTel'];?></td>
                <td><a href="mailto:<?php echo $row['clientEmail'];?>"><?php echo $row['clientEmail'];?></a></td>
                <td><?php echo $row['clientFax'];?></td>
                <td><?php echo $row['contact1Name'];?></td>
                <td><a href="mailto:<?php echo $row['contact1Email'];?>"><?php echo $row['contact1Email'];?></a></td>
                <td><?php echo $row['contact1Mobile'];?></td>
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