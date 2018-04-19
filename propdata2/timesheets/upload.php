<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['timelogged']) && $_POST['timelogged'] <> "")
{
	        if (!mysqli_query($conn,"INSERT INTO timesheets (
                timesheetUserId,
                timetask,
                timelogged,
                timetaskComment,
                timesheetJobNo,
                timeAdded
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['timesheetUserId'])."',
                    '".mysqli_real_escape_string($conn,$_POST['timetask'])."',
                    '".mysqli_real_escape_string($conn,$_POST['timelogged'])."',
                    '".mysqli_real_escape_string($conn,$_POST['timetaskComment'])."',
                    '".mysqli_real_escape_string($conn,$_POST['timesheetJobNo'])."',
                    NOW()
                    )"
            )) {
                echo '<span class="errormsg">Error Saving Time Spent on Job: '.mysqli_error($conn).'</span>';
            } else {
                $newtimeId = mysqli_insert_id($conn);
                /*
                $commentsresult = mysqli_query($conn,"SELECT accountExec FROM jobs WHERE jobno = '".mysqli_real_escape_string($conn,$_POST['timesheetJobNo'])."'");
                while ($crow = mysqli_fetch_array($commentsresult) ) {
                        mysqli_query($conn,"INSERT INTO commentsread (
                        crId,
                        crJobNo,
                        cruserId,
                        crstatus
                        ) VALUES (
                        '".$newtimeId."',
                        '".$_POST['commentJobNo']."',
                        '".$crow['accountExec']."',
                        '0'
                        )"
                        );
                }
                */
            }
//echo json_encode(array('count' => $count));
    header ("Location: http://jobs.firetree.co.za/jobs/job.php?jobNo=".$_POST['timesheetJobNo']);

}

?>