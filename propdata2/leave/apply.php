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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['firstDayOff']) && $_POST['firstDayOff'] <> "")
{
    if (isset($_POST['halfday']) && $_POST['halfday'] == "Yes") {
        $firstDayBack = $_POST['firstDayOff'];
    } else {
        $firstDayBack = $_POST['firstDayBack'];
    }
    if ($_SESSION['manager'] == "1") {
        $approvedManager = "1";
    } else {
        $approvedManager = "0";
    }

    if (!mysqli_query($conn,"INSERT INTO leaveTable (
                leaveUserId,
                typeOfLeave,
                firstDayOff,
                firstDayBack,
                totalDays,
                reason,
                applicationDate,
                approvedManager,
                approvedDebbie
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['leaveUserId'])."',
                    '".mysqli_real_escape_string($conn,$_POST['typeOfLeave'])."',
                    '".mysqli_real_escape_string($conn,$_POST['firstDayOff'])."',
                    '".$firstDayBack."',
                    '".mysqli_real_escape_string($conn,$_POST['totalDays'])."',
                    '".strip_tags(mysqli_real_escape_string($conn,$_POST['reason']))."',
                    NOW(),
                    '".$approvedManager."',
                    '0'
                    )"
    )) {
        echo '<span class="errormsg">Error Submitting Leave Application: '.mysqli_error($conn).'</span>';
    } else {
        $newleaveId = mysqli_insert_id($conn);

        $result = mysqli_query($conn,"select firstname, surname, email from users where userId = '".$_POST['leaveUserId']."'");
        while ($row = mysqli_fetch_array($result) ) {
            $firstname = $row['firstname'];
            $surname = $row['surname'];
            $email = $row['email'];
        }
        $result = mysqli_query($conn,"select leaveTypeName from leaveType where leaveTypeId = '".$_POST['typeOfLeave']."'");
        while ($row = mysqli_fetch_array($result) ) {
            $leaveTypeName = $row['leaveTypeName'];
        }

        if (isset($_POST['halfday']) && $_POST['halfday'] == "Yes") {
            $halfDay = 'Yes';
        } else {
            $halfDay = 'No';
        }
        //mail to manager
        if ($approvedManager <> "1") {
            $subject = 'Leave Application: '.$firstname.' '.$surname;
            $headers = "From: ".$email."\r\n";
            $headers .= "Reply-To: ".$email."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = '<html><body>';
            $message = 'Hi Desmond,<br/>
                            <br/>
                            There is a new leave application from '.$firstname.' '.$surname.'.<br/>
                            <br/><strong>Leave Type:</strong> '.$leaveTypeName.'
                            <br/><strong>Half Day:</strong> '.$halfDay.'
                            <br/><strong>Start Date of Leave:</strong> '.date("l, d F Y",$_POST['firstDayOff']).'
                            <br/><strong>Date Back at Work:</strong> '.date("l, d F Y",$firstDayBack).'
                            <br/><strong>Total Days:</strong> '.$_POST['totalDays'].'
                            <br/><strong>Reason:</strong> '.$_POST['reason'].'
                            <br/>
                            <br/>
                            <strong>Options:</strong><br/>
                            <a href="http://jobs.firetree.co.za/leave/leaveApprovalManager.php?leaveId='.$newleaveId.'&approve=Yes">Approve</a> or <a href="http://jobs.firetree.co.za/leave/leaveApprovalManager.php?leaveId='.$newleaveId.'&approve=No">Deny</a><br/>';
            $message .= '</body></html>';
            mail("des@firetree.co.za", $subject, $message, $headers);
        } else {
            //mail to
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
                            <br/><strong>Start Date of Leave:</strong> '.date("l, d F Y",str_replace("/","-",strtotime($_POST['firstDayOff']." 00:00:00"))).'
                            <br/><strong>Date Back at Work:</strong> '.date("l, d F Y",str_replace("/","-",strtotime($firstDayBack." 00:00:00"))).'
                            <br/><strong>Total Days:</strong> '.$_POST['totalDays'].'
                            <br/><strong>Reason:</strong> '.$_POST['reason'].'
                            <br/>
                            <br/>
                            <br/><strong>Studio Manager Approval:</strong> Not Required.
                            <br/>
                            <br/>
                            <strong>Options:</strong><br/>
                            <a href="http://jobs.firetree.co.za/leave/leaveApprovalDebbie.php?leaveId='.$newleaveId.'&approve=Yes">Approve</a> or <a href="http://jobs.firetree.co.za/leave/leaveApprovalDebbie.php?leaveId='.$newleaveId.'&approve=No">Deny</a><br/>';
            $message .= '</body></html>';
            mail("debbie@firetree.co.za", $subject, $message, $headers);
        }

        $successMsg= '<div style="margin: 80px 0 20px 0;padding: 10px;border-radius: 5px;" class="alert alert-success">Leave successfully submitted</div>';
    }

}

?>


    <div id="page-wrapper">
    <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Fire Tree Leave Application</h1>
    </div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="<?php echo HTTP.'js/jquery-ui.js';?>"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $( "#firstDayOff" ).datepicker({ beforeShowDay: $.datepicker.noWeekends });
            $( "#firstDayBack" ).datepicker({ beforeShowDay: $.datepicker.noWeekends });
        });
    });

    function submitFunction() {
        formatDate('#firstDayOff');
        formatDate('#firstDayBack');
        halfdaycheck();
        if (jQuery("#typeOfLeave").val() == "") {
            alert ("You must select a Leave Type");
            return false;
        }

        if (jQuery("#firstDayOff").val() == "") {
            alert ("You must select a Leave Start Date");
            return false;
        }
        if (jQuery("#totalDays").val() <= 0) {
            alert ("Make sure your Return to Work Date is after your Start Date");
            return false;
        }
        if (jQuery("#reason").val() == "") {
            alert ("Please enter your Reason For Leave");
            return false;
        }
        return true;
    }

</script>


<div id="leaveform">
    <!-- status message will be appear here -->
    <?php echo $successMsg;?>

    <!-- multiple file upload form -->
    <form action="<?php echo HTTP;?>leave/apply.php" onsubmit="return submitFunction();" method="post" enctype="multipart/form-data" class="pure-form" id="myForm">

        <div class="form-group">
            <label>Type of Leave</label><br/>
            <select name="typeOfLeave" id="typeOfLeave" data-placeholder="Type of Leave">
                <option value="">Type of Leave</option>
                <?php
                $result = mysqli_query($conn,"SELECT * from leaveType order by leaveTypeName");
                while ($row = mysqli_fetch_array($result) ) {
                    echo '<option value="'.$row['leaveTypeId'].'">'.$row['leaveTypeName'].'</option>';
                }
                ?>
            </select><br/>
            <input type="hidden" name="dateFormat" value="yyyy-mm-dd">
            <script type="text/javascript">
                function isValidDate(dateString) {
                    var regEx = /^\d{4}-\d{2}-\d{2}$/;
                    return dateString.match(regEx) != null;
                }
                function formatDate(thisid){
                    if (!isValidDate(jQuery(thisid).val())) {
                        jQuery( thisid ).datepicker( "option", "dateFormat", "yy/mm/dd" );
                    }
                }
                function workingDaysBetweenDates(startDate, endDate) { // input given as Date objects
                    var millisecondsPerDay = 86400 * 1000;
                    startDate.setHours(0,0,0,1);
                    endDate.setHours(23,59,59,999);
                    var diff = endDate - startDate;
                    var days = Math.ceil(diff / millisecondsPerDay);

                    // Subtract two weekend days for every week in between
                    var weeks = Math.floor(days / 7);
                    days = days - (weeks * 2);

                    // Handle special cases
                    var startDay = startDate.getDay();
                    var endDay = endDate.getDay();

                    // Remove weekend not previously removed.
                    if (startDay - endDay > 1) {
                        days = days - 2;
                    }

                    // Remove start day if span starts on Sunday but ends before Saturday
                    if (startDay === 0 && endDay != 6) {
                        days = days - 1 ;
                    }

                    // Remove end day if span ends on Saturday but starts after Sunday
                    if (endDay === 6 && startDay !== 0) {
                        days = days - 1  ;
                    }
                    days = days - 1;
                    return days;
                }
                function halfdaycheck() {
                    if (jQuery('input[name="halfday"]:checked').val() == "Yes") {
                        jQuery("#daybackdiv").hide();
                        jQuery("#totalDays").val("0.5");
                        jQuery("#totalLeaveDays").html("0.5");
                    } else {
                        jQuery("#daybackdiv").show();

                        if (jQuery("#firstDayBack").val() !== "") {
                            var a = jQuery("#firstDayOff").val();
                            var b = jQuery("#firstDayBack").val();
                            a = new Date(a);
                            b = new Date(b);

                            workingDays = workingDaysBetweenDates(a,b);
                            if (workingDays < 1) {
                                alert ("Please select a return date that is after the start date.");
                                jQuery("#firstDayBack").val("");
                                jQuery("#totalDays").val("0");
                                jQuery("#totalLeaveDays").html("0");
                            } else {
                                jQuery("#totalDays").val(workingDays);
                                jQuery("#totalLeaveDays").html(workingDays);
                            }
                        } else {
                            jQuery("#firstDayBack").val("");
                            jQuery("#totalDays").val("0");
                            jQuery("#totalLeaveDays").html("0");
                        }
                    }
                }
            </script>
        </div>
        <div class="form-group">
            <span class="errmsg" id="errtimelogged"></span>
            <label>Half Day?</label><br/>
            <input type="checkbox" class="form-control" name="halfday" id="halfday" value="Yes" onSelect="halfdaycheck();" onClick="halfdaycheck();" onchange="halfdaycheck();" onBlur="halfdaycheck();" style="width:30px!important;">
        </div>
        <div class="form-group">
            <label>Date Leave to Start</label>
            <input onClick="halfdaycheck();" onchange="halfdaycheck();formatDate('#firstDayOff');" onBlur="halfdaycheck();" placeholder="First Day Off" class="form-control" name="firstDayOff" id="firstDayOff">
        </div>
        <div class="form-group" id="daybackdiv">
            <label>Date Back at Work</label>
            <input onClick="halfdaycheck();" onchange="halfdaycheck();formatDate('#firstDayBack');" onBlur="halfdaycheck();" placeholder="First Day Back" class="form-control" name="firstDayBack" id="firstDayBack">
        </div>
        <div class="form-group">
            <label>Total Leave Days</label><br/>
            <span id="totalLeaveDays" style="color:#cc0000;font-weight: bold;">0</span>
            <input type="hidden" name="totalDays" id="totalDays">
        </div>
        <div class="form-group">
            <label>Reason for Leave (More information)</label><br/>
            <textarea name="reason" id="reason" rows="3" cols="40"></textarea><br/><br/>
        </div>
        <input type="hidden" name="leaveUserId" value="<?php echo $_SESSION['userId'];?>">
        <input type="submit" value="Apply for Leave" class="btn-success btn-sm btn">
    </form>

</div>

    </div></div>





<?php } ?>
<?php include '../pagebottom.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        halfdaycheck();
    });
</script>