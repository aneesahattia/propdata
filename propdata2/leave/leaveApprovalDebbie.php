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
                if (!mysqli_query($conn,"update leaveTable set approvedDebbie='1' where leaveId ='".$_GET['leaveId']."'"
                )) {
                    echo '<span class="errormsg">Error Approving Leave Application: '.mysqli_error($conn).'</span>';
                } else {
                    //mail User with the good news
                    $subject = 'Leave Application: '.$firstname.' '.$surname;
                $headers = "From: debbie@firetree.co.za\r\n";
                $headers .= "Reply-To: debbie@firetree.co.za\r\n";
                $headers .= "Cc: des@firetree.co.za\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $message = '<html><body>';
                $message = 'Hi '.$firstname.' '.$surname.',<br/>
                            <br/>
                            Your leave application from '.date("l, d F Y",str_replace("/","-",strtotime($firstDayOff))).' to '.date("l, d F Y",str_replace("/","-",strtotime($firstDayBack))).' has been approved. <br/><br/>Kind regards,<br/>Debbie';
                $message .= '</body></html>';
                mail($email, $subject, $message, $headers);
                    $successMsg= '<div style="margin: 80px 0 20px 0;padding: 10px;border-radius: 5px;" class="alert alert-success">Leave successfully approved and '.$firstname.' '.$surname.' has been notified.</div>';
                }
            } elseif ($_GET['approve'] == "No") {
                if (!mysqli_query($conn,"update leaveTable set approvedDebbie='0' where leaveId ='".$_GET['leaveId']."'"
                )) {
                    echo '<span class="errormsg">Error Denying Leave Application: '.mysqli_error($conn).'</span>';
                } else {
                    //mail User with the bad news
                    $subject = 'Leave Application: '.$firstname.' '.$surname;
                    $headers = "From: debbie@firetree.co.za\r\n";
                    $headers .= "Reply-To: debbie@firetree.co.za\r\n";
                    $headers .= "Cc: des@firetree.co.za\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message = 'Hi '.$firstname.' '.$surname.',<br/>
                            <br/>
                            Your leave application from '.date("l, d F Y",str_replace("/","-",strtotime($firstDayOff))).' to '.date("l, d F Y",str_replace("/","-",strtotime($firstDayBack))).' has been denied. <br/><br/>Kind regards,<br/>Debbie';
                    $message .= '</body></html>';
                    mail($email, $subject, $message, $headers);
                    $successMsg= '<div style="margin: 80px 0 20px 0;padding: 10px;border-radius: 5px;" class="alert alert-success">Leave has been denied and '.$firstname.' '.$surname.' has been notified.</div>';
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