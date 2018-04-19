<?php
include '../conn.php';
$result = mysqli_query($conn,"SELECT c.*,concat(u.firstname, ' ', u.surname) as commenter, u.profilePicture from comments c left join users u on u.userId = c.commenter where c.commentJobNo = '".$jobNo."' order by c.commentDate DESC");
$count = mysqli_num_rows($result);
if ($count < 1) {
    echo 'There are no comments for this Job.';
} else {
    $align="left";
    $align2="right";
    $bgcol = '#F6FDFF';
    while ($row = mysqli_fetch_array($result) ) {
        echo '<div style="border: #cceeee 1px solid; margin:2px; padding: 10px 10px 1px 10px; border-radius: 10px; background-color: '.$bgcol.';text-align:'.$align.';width:100%;"><span class="small" style="text-align:'.$align2.';float:'.$align2.';">'.date("d F y, H:i",strtotime($row['commentDate'])).'</span><span class="text-muted1 small"><strong><img src="'.HTTP.'uploads/'.$row['profilePicture'].'" style="border-radius:5px;height:40px;"><br/>'.$row['commenter'].'</strong></span><br/><span class="small">'.$row['comment'].'</span></div>';
        if ($align == "left") {
            $align = "right";
            $align2 = "left";
            $bgcol = '#F9FFFA';
        } else {
            $align = "left";
            $align2="right";
            $bgcol = '#F6FDFF';
        }
    }
}
?>