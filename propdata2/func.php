<?php
include ('conn.php');
//**************************************
//     Page load dropdown results     //
//**************************************


function getTierOne()
{
    $clientsresult = mysqli_query($conn,"SELECT clientId, clientName from clients order by clientName ASC");
    while ($crow = mysqli_fetch_array($clientsresult) ) {
        echo '<option value="'.$crow['clientId'].'">'.$crow['clientName'].'</option>';
    }
}

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "drop_1" && isset($_GET['func'])) { 
   drop_1($_GET['drop_var']); 
}

function drop_1($drop_var)
{
	$clientsresult = mysqli_query($conn,"SELECT projectName, projectId from projects where client = '".$drop_var."' order by projectName ASC");
	echo '<select name="project" id="project">
	      <option value=" " disabled="disabled" selected="selected">Select Project</option>';
            while ($crow = mysqli_fetch_array($clientsresult) ) {
                echo '<option value="'.$crow['projectId'].'">'.$crow['projectName'].'</option>';
            }
	echo '</select> ';
    echo '<script type="text/javascript">displayForm();</script>';
}
?>