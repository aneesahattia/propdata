<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment']) && $_POST['comment'] <> "")
{
	        if (!mysqli_query($conn,"INSERT INTO comments (
                commenter,
                comment,
                commentJobNo,
                commentDate
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['commenter'])."',
                    '".mysqli_real_escape_string($conn,$_POST['comment'])."',
                    '".mysqli_real_escape_string($conn,$_POST['commentJobNo'])."',
                    NOW()
                    )"
            )) {
                echo '<span class="errormsg">Error uploading comment: '.mysqli_error($conn).'</span>';
            } else {

                $result = mysqli_query($conn,"select firstname from users where userId = '".$_POST['commenter']."'");
                while ($row = mysqli_fetch_array($result) ) {
                    $commentername = $row['firstname'];
                }



                $result = mysqli_query($conn,"SELECT concat(u1.firstname, ' ', u1.surname) AS assigneeName, u1.email as assigneeemail FROM jobs jo LEFT JOIN relationalJobUsers rj on rj.jobNo = jo.jobNo LEFT JOIN users u1 ON u1.userId = rj.userId WHERE jo.jobNo = '".$_POST['commentJobNo']."' and rj.userId <> '".$_POST['commenter']."'");
                while ($row = mysqli_fetch_array($result) ) {
                    $to = $row['assigneeemail'];
                    $subject = 'New Comment for Job #'.$_POST['commentJobNo'];

                    $headers = "From: jobs@firetree.co.za\r\n";
                    $headers .= "Reply-To: jobs@firetree.co.za\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message = 'Hi '.$row['assigneeName'].',<br/>
                    <br/>
                    There is a new comment on Job #'.$_POST['commentJobNo'].'.<br/>
                    <br/><strong>'.$commentername.' wrote: '.$_POST['comment'].'</strong><br/>
                    <br/>
                    <a href="http://jobs.firetree.co.za/jobs/job.php?jobNo='.$_POST['commentJobNo'].'">Click here to view the Job</a><br/>
                    <br/>
                    <a href="http://jobs.firetree.co.za">Jobs.FireTree.co.za</a>';
                    $message .= '</body></html>';
                    mail($to, $subject, $message, $headers);
                }








                $newcommentId = mysqli_insert_id($conn);
                $commentsresult = mysqli_query($conn,"SELECT accountExec FROM jobs WHERE jobno = '".mysqli_real_escape_string($conn,$_POST['commentJobNo'])."'");
                while ($crow = mysqli_fetch_array($commentsresult) ) {
                    if ($crow['accountExec'] <> $_POST['commenter']) {
                        mysqli_query($conn,"INSERT INTO commentsread (
                        crId,
                        crJobNo,
                        cruserId,
                        crstatus
                        ) VALUES (
                        '".$newcommentId."',
                        '".$_POST['commentJobNo']."',
                        '".$crow['accountExec']."',
                        '0'
                        )"
                        );
                    }
                }
                $commentsresult = mysqli_query($conn,"SELECT GROUP_CONCAT(rj.userId) as accountExec FROM jobs j LEFT JOIN relationalJobUsers rj ON rj.jobNo = j.jobNo left join users u1 on u1.userId = rj.userId left join users u2 on u2.userId = j.accountExec WHERE j.jobno = '".mysqli_real_escape_string($conn,$_POST['commentJobNo'])."' and rj.userId <> '".$_POST['commenter']."' group by rj.userId");
                while ($crow = mysqli_fetch_array($commentsresult) ) {
                mysqli_query($conn,"INSERT INTO commentsread (
                        crId,
                        crJobNo,
                        cruserId,
                        crstatus
                        ) VALUES (
                        '".$newcommentId."',
                        '".$_POST['commentJobNo']."',
                        '".$crow['accountExec']."',
                        '0'
                        )"
                );
                }

            }
//echo json_encode(array('count' => $count));
    header ("Location: http://jobs.firetree.co.za/jobs/job.php?jobNo=".$_POST['commentJobNo']);

}

?>