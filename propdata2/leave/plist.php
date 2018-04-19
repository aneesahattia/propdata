
<?php
include '../conn.php';
$result = mysqli_query($conn,"SELECT t.*,concat(u.firstname, ' ', u.surname) as logger, u.profilePicture, tasks.taskName from timesheets t left join tasks tasks on tasks.taskId = t.timetask left join users u on u.userId = t.timesheetUserId left join jobs j on j.jobNo = t.timesheetJobNo where j.project = '".$_GET['projectId']."' order by t.timeAdded DESC");
$count = mysqli_num_rows($result);
$timelogged=0;
if ($count < 1) {
    echo 'No time has been logged for this Job.';
} else {
    ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>User</th>
            <th>Job #</th>
            <th>Task</th>
            <th>Time</th>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result) ) {
        echo '<tr onclick="window.location.href=\''.HTTP.'jobs/job.php?jobNo='.$row['timesheetJobNo'].'\';">';
        echo '<td style="text-align: center;" class="small"><img style="border-radius:5px;height:40px;" src="'.HTTP.'uploads/'.$row['profilePicture'].'" alt="'.$row['logger'].'" title="'.$row['logger'].'"><br/>'.$row['logger'].'</td><td class="small">#'.$row['timesheetJobNo'].'</td><td class="small">'.$row['taskName'].'<br/>'.$row['timetaskComment'].'</td><td>'.$row['timelogged'].'</td>';
        echo '</tr>';
        $timelogged = $timelogged + $row['timelogged'];
    }
?>
        <?php
        $result = mysqli_query($conn,"SELECT jo.jobNo,	concat(u1.firstname, ' ', u1.surname) AS assigneeName, u1.profilePicture FROM jobs jo LEFT JOIN relationalJobUsers rj on rj.jobNo = jo.jobNo LEFT JOIN users u1 ON u1.userId = rj.userId WHERE jo.project = '".$_GET['projectId']."'");
    while ($row = mysqli_fetch_array($result) ) {
        echo '<tr onclick="window.location.href=\''.HTTP.'jobs/job.php?jobNo='.$row['jobNo'].'\';">';
        echo '<td style="text-align: center;" class="small"><img style="border-radius:5px;height:40px;" src="'.HTTP.'uploads/'.$row['profilePicture'].'" alt="'.$row['assigneeName'].'" title="'.$row['assigneeName'].'"><br/>'.$row['assigneeName'].'</td><td class="small"><span style="color:#cc0000">#'.$row['jobNo'].'</span></td><td class="small"><span style="color:#cc0000">No time has been logged for this project.</span></td><td><span style="color:#cc0000">0</span></td>';
        echo '</tr>';
    }
        ?>

        <tr><td colspan="3" style="text-align: right;"><strong>Total Time (minutes)</strong></td><td><strong><?php echo $timelogged; ?></strong></td></tr>
    </table>
<?php
}

?>