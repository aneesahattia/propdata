<?php session_start(); ?>
<?php
$thistitle='Leave ::';
$where = '  ';
$sortBy= '';
include '../pagetop.php';
?>
<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include '../loginform.php'; ?>
<?php } else {

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['leaveId']) && $_GET['leaveId'] <> "" && isset($_GET['approve']) && $_GET['approve'] <> "" )
    {
        if ($_SESSION['userId'] == "1") {

            $result = mysqli_query($conn,"select l.*, lt.leaveTypeName, u.firstname, u.surname, u.email from leaveTable l left join leaveType lt on l.typeOfleave = lt.leaveTypeId left join users u on u.userId = l.leaveUserId where l.leaveId = '".$_GET['leaveId']."'");
            while ($row = mysqli_fetch_array($result) ) {
                $leaveTypeName = $row['leaveTypeName'];
                $firstname = $row['firstname'];
                $surname = $row['surname'];
                $email = $row['email'];
                if ($row['totalDays'] == "0.5") {
                    $halfDay = 'Yes';
                } else {
                    $halfDay = 'No';
                }
                $firstDayOff = $row['firstDayOff'];
                $firstDayBack = $row['firstDayBack'];
                $totalDays = $row['totalDays'];
                $reason = $row['reason'];
            }


            if ($_GET['approve'] == "Yes") {
                if (!mysqli_query($conn,"update leaveTable set approvedManager='1' where leaveId ='".$_GET['leaveId']."'"
                )) {
                    echo '<span class="errormsg">Error Approving Leave Application: '.mysqli_error($conn).'</span>';
                } else {
                    //mail Debbie
                    $subject = 'Leave Application: '.$firstname.' '.$surname;
                    $headers = "From: ".$email."\r\n";
                    $headers .= "Reply-To: ".$email."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message = 'Hi Debbie,<br/>
                            <br/>
                            There is a new leave application from '.$firstname.' '.$surname.'.<br/>
                            <br/><strong>Leave Type:</strong> '.$leaveTypeName.'
                            <br/><strong>Half Day:</strong> '.$halfDay.'
                            <br/><strong>Start Date of Leave:</strong> '.date("l, d F Y",str_replace("/","-",strtotime($firstDayOff." 00:00:00"))).'
                            <br/><strong>Date Back at Work:</strong> '.date("l, d F Y",str_replace("/","-",strtotime($firstDayBack." 00:00:00"))).'
                            <br/><strong>Total Days:</strong> '.$totalDays.'
                            <br/><strong>Reason:</strong> '.$reason.'
                            <br/>
                            <br/>
                            <br/><strong>Studio Manager Approval:</strong> <u>Approved</u>
                            <br/>
                            <br/>
                            Options:<br/>
                            <a href="http://jobs.firetree.co.za/leave/leaveApprovalDebbie.php?leaveId='.$_GET['leaveId'].'&approve=Yes">Approve</a><br/>
                            <a href="http://jobs.firetree.co.za/leave/leaveApprovalDebbie.php?leaveId='.$_GET['leaveId'].'&approve=No">Deny</a><br/>';
                    $message .= '</body></html>';
                    mail("debbie@firetree.co.za", $subject, $message, $headers);

                    $successMsg= '<div style="margin: 80px 0 20px 0;padding: 10px;border-radius: 5px;" class="alert alert-success">Leave successfully approved and sent to Debbie for further approval.</div>';
                }
            } elseif ($_GET['approve'] == "No") {
                if (!mysqli_query($conn,"update leaveTable set approvedManager='0' where leaveId ='".$_GET['leaveId']."'"
                )) {
                    echo '<span class="errormsg">Error Denying Leave Application: '.mysqli_error($conn).'</span>';
                } else {
                    //mail User with the bad news
                    $subject = 'Leave Application: '.$firstname.' '.$surname;
                    $headers = "From: des@firetree.co.za\r\n";
                    $headers .= "Reply-To: des@firetree.co.za\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message = 'Hi '.$firstname.' '.$surname.',<br/>
                            <br/>
                            Your leave application from '.date("l, d F Y",str_replace("/","-",strtotime($firstDayOff))).' to '.date("l, d F Y",str_replace("/","-",strtotime($firstDayBack))).' has been denied. Please don\'t hate me.<br/><br/>Kind regards, Des';
                    $message .= '</body></html>';
                    mail($email, $subject, $message, $headers);
                    $successMsg= '<div style="margin: 80px 0 20px 0;padding: 10px;border-radius: 5px;" class="alert alert-success">Leave has been denied and user has been notified.</div>';
                }
            }
        }
    }

    ?>


    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Fire Tree Leave Application</h1>
            </div>
            <?php echo $successMsg;?>
        </div>
    </div>





<?php } ?>
<?php include '../pagebottom.php'; ?>