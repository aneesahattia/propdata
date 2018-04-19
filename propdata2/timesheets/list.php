<?php
include '../conn.php';
$result = mysqli_query($conn,"SELECT t.*,concat(u.firstname, ' ', u.surname) as logger, u.profilePicture, tasks.taskName from timesheets t left join tasks tasks on tasks.taskId = t.timetask left join users u on u.userId = t.timesheetUserId where t.timesheetJobNo = '".$jobNo."' order by t.timeAdded DESC");
$count = mysqli_num_rows($result);
$timelogged=0;
if ($count < 1) {
    echo 'No time has been logged for this Job.';
} else {
    ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <th>User</th>
            <th>Task</th>
            <th>Time</th>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result) ) {
        echo '<tr>';
        echo '<td style="text-align: center;" class="small"><img style="border-radius:5px;height:40px;" src="'.HTTP.'uploads/'.$row['profilePicture'].'" alt="'.$row['logger'].'" title="'.$row['logger'].'"><br/>'.$row['logger'].'</td><td class="small">'.$row['taskName'].'<br/>'.$row['timetaskComment'].'</td><td>'.$row['timelogged'].'</td>';
        echo '</tr>';
        $timelogged = $timelogged + $row['timelogged'];
    }
?>
        <tr><td colspan="2"><strong>Total Time (minutes)</strong></td><td><strong><?php echo $timelogged; ?></strong></td></tr>
    </table>
<?php
}

?>