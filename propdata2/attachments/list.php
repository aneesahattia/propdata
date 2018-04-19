<?php
include '../conn.php';
$result = mysqli_query($conn,"SELECT a.*,concat(u.firstname, ' ', u.surname) as uploader from attachments a left join users u on u.userId = a.attacher where a.attachmentJobNo = '".$jobNo."' order by a.attachmentDate DESC");
$count = mysqli_num_rows($result);
if ($count < 1) {
    echo 'There are no attachments for this Job.';
} else {
    while ($row = mysqli_fetch_array($result) ) {
        echo 'On '.date("d F y, H:i",strtotime($row['attachmentDate'])).', '.$row['uploader'].' attached a file:<br/>';
        echo '<a target="_blank" href="'.HTTP.'uploads/'.$row['attachment'].'">'.$row['attachment'].'</a>';
        echo '<hr>';
    }
}
?>