<?php
//**************************************
//     Page load dropdown results     //
//**************************************

function getTierOne()
{
    include '../conn.php';
    $clientsresult = mysqli_query($conn,"SELECT clientId, clientName from clients order by clientName ASC");
    echo '<div class="form-group">
                    <label>Select Client *</label>
                    <select class="form-control" id="client" name="client">
                        <option value="">Select Client</option>';
                        while ($crow = mysqli_fetch_array($clientsresult) ) {
                            echo '<option ';
                            if (isset($_GET['clientId']) && $_GET['clientId'] <> "") {
                                if ($_GET['clientId'] == $crow['clientId']) { echo ' selected = "selected" '; }
                            }
                            echo 'value="'.$crow['clientId'].'">'.$crow['clientName'].'</option>';
                        }
                echo '</select>';
        echo '</div>';
}

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "client" && isset($_GET['func'])) {
    if (isset($_GET['proj']) && $_GET['proj'] <> "") {
        $proj = $_GET['proj'];
        drop_1($_GET['drop_var'],$proj);
    } else {
        drop_1($_GET['drop_var'],'');
    }

}

function drop_1($drop_var,$proj)
{
    include '../conn.php';
	$clientsresult = mysqli_query($conn,"SELECT projectLead, accountExec, projectName, projectId from projects where client = '".$drop_var."' order by projectName ASC");
    $thecount = mysqli_num_rows($clientsresult);
        echo '<div class="form-group">';
    if ($thecount < 1) {
        echo 'There are no Projects for this Client - <a href="../projects/createproject.php?clientId='.$drop_var.'">Create Project Now</a>';
        echo '<script type="text/javascript">hideForm();</script>';
    } else {
        echo '<label>Select Project *</label>';
        echo '<select class="form-control" name="project" id="project">
              <option value="">Select Project</option>
              <option value="NEW">Create New Project</option>';
        while ($crow = mysqli_fetch_array($clientsresult) ) {
            $projectLead = $crow['projectLead'];
            $accountExec = $crow['accountExec'];
            echo '<option ';
            if (isset($proj) && $proj <> "") {
                if ($proj == $crow['projectId']) { echo ' selected = "selected" '; }
            }
            echo 'value="'.$crow['projectId'].'">'.$crow['projectName'].'</option>';
        }
        echo '</select> ';
        echo '<script type="text/javascript">displayForm();jQuery("#assignee").val("'.$projectLead.'");jQuery("#accountExec").val("'.$accountExec.'");</script>';
        echo '<script type="text/javascript">
                jQuery("#project").change(function(){
                    if (jQuery("#project").val() == "NEW") {
                        window.location.href="../projects/createproject.php?clientId='.$drop_var.'"; 
                    }
                });
        </script>';
    }
        echo '</div>';

}
?>