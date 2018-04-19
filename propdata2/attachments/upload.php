<?php
include '../conn.php';
/**
 * Multiple file upload with progress bar php and jQuery
 * 
 * @author Resalat Haque
 * @link http://www.w3bees.com
 * 
 */

$max_size = 200000000; // 200kb
$extensions = array('jpeg', 'jpg', 'png', 'pdf', 'gif', 'tif', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'rar', 'bmp', 'txt', 'ttf', 'otf','JPEG', 'JPG', 'PNG', 'PDF', 'GIF', 'TIF', 'ZIP', 'DOC', 'DOCX', 'XLS', 'XLSX', 'RAR', 'BMP', 'TXT', 'TTF', 'OTF');
$dir = '../uploads/';
$count = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_FILES['files']))
{
	// loop all files
	foreach ( $_FILES['files']['name'] as $i => $name )
	{
        $name = date("YmdHis")."_".$name;
		// if file not uploaded then skip it
		if ( !is_uploaded_file($_FILES['files']['tmp_name'][$i]) ) {
            continue;
        }

	    // skip large files
		if ( $_FILES['files']['size'][$i] >= $max_size ) {
            continue;
        }

		// skip unprotected files
		if( !in_array(pathinfo($name, PATHINFO_EXTENSION), $extensions) ) {
            continue;
        }


		// now we can move uploaded files
	    if(move_uploaded_file($_FILES["files"]["tmp_name"][$i], $dir . $name) ) {
	    	$count++;
            if (!mysqli_query($conn,"INSERT INTO attachments (
                attacher,
                attachment,
                attachmentJobNo,
                attachmentDate
                    ) VALUES (
                '".mysqli_real_escape_string($conn,$_POST['attacher'])."',
                    '".$name."',
                    '".mysqli_real_escape_string($conn,$_POST['attachmentJobNo'])."',
                    NOW()
                    )"
            )) {
                echo '<span class="errormsg">Error uploading attachment: '.mysqli_error($conn).'</span>';
            } else {
                //successfully uploaded
                $result = mysqli_query($conn,"select u.firstname, u.surname, u.email from users u left join relationalJobUsers rj on rj.userId = u.userId where rj.jobNo = '".$_POST['attachmentJobNo']."' and rj.userId <> '".$_POST['attacher']."' ");
                while ($row = mysqli_fetch_array($result) ) {
                        $to = $row['email'];
                        $subject = 'New Attachment Added for Job #'.$_POST['attachmentJobNo'];

                        $headers = "From: jobs@firetree.co.za\r\n";
                        $headers .= "Reply-To: jobs@firetree.co.za\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $message = '<html><body>';
                        $message = 'Hi '.$row['firstname'].',<br/>
                        <br/>
                        A new file has been attached for Job #'.$_POST['attachmentJobNo'].'.<br/>
                        File name: '.$name.'<br/>
                        <br/>
                        <a href="http://jobs.firetree.co.za/jobs/job.php?jobNo='.$_POST['attachmentJobNo'].'">Click here to view the Job</a><br/>
                        <br/>
                        <a href="http://jobs.firetree.co.za">Jobs.FireTree.co.za</a>';
                        $message .= '</body></html>';
                        mail($to, $subject, $message, $headers);
                }
            }
        }
    }
//echo json_encode(array('count' => $count));
    header ("Location: http://jobs.firetree.co.za/jobs/job.php?jobNo=".$_POST['attachmentJobNo']);

}

?>