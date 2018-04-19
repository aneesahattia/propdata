<?php session_start(); ?>
<?php
$thistitle='Create a Job ::';
include '../pagetop.php';
include 'func.php';
?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php include '../loginform.php'; ?>
<?php } else { ?>
    <div id="page-wrapper">
    <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create a Job</h1>
    </div>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="<?php echo HTTP.'js/jquery-ui.js';?>"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                $( "#deadline" ).datepicker();
            });
        });

    </script>






























        <head>
            <script type="text/javascript">
                function GetUrlValue(VarSearch){
                    var SearchString = window.location.search.substring(1);
                    var VariableArray = SearchString.split('&');
                    for(var i = 0; i < VariableArray.length; i++){
                        var KeyValuePair = VariableArray[i].split('=');
                        if(KeyValuePair[0] == VarSearch){
                            return KeyValuePair[1];
                        }
                    }
                }

                $(document).ready(function() {
                    $('#wait_1').hide();
                    $('#client').change(function(){
                        t1();
                    });
                    $("#estimatedMinutes").keypress(function (e) {
                        //if the letter is not digit then display error and don't type anything
                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            //display error message
                            $("#errestimatedMinutes").html("Enter number(s) only.").show().fadeOut(2000);
                            return false;
                        }
                    });
                });

                function t1() {
                    $('#wait_1').show();
                    $('#result_1').hide();
                    $.get("func.php", {
                        func: "client",
                        drop_var: $('#client').val(),
                        proj: GetUrlValue('projectId')
                    }, function(response){
                        $('#result_1').fadeOut();
                        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
                    });
                    return false;
                }

                function finishAjax(id, response) {
                    $('#wait_1').hide();
                    $('#'+id).html(unescape(response));
                    $('#'+id).fadeIn();
                }
            </script>
            <?php
                if (isset($_GET['clientId']) && isset($_GET['projectId'])) { ?>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            t1();
                        });
                    </script
            <?php } ?>
        </head>

    <script type="text/javascript">
        function displayForm(){
            jQuery('#displayForm').show();
        }
        function hideForm(){
            jQuery('#displayForm').hide();
        }
        function Checker( variable, errorvariable ){
            if (jQuery(variable).val() == ""){
                jQuery(variable).removeClass("inputsuccess").addClass("inputerror");
                jQuery(errorvariable).fadeIn();
                jQuery(variable).focus();
                isFalse = isFalse + 1;
                alertmsg = "Please correct all highlighted fields.";
            } else {
                jQuery(variable).removeClass("inputerror").addClass("inputsuccess");
                jQuery(errorvariable).fadeOut();
            }
        }

        function validateForm() {
            isFalse = 0;
            Checker("#userId","#erroruserId");
            Checker("#leaveType","#errorleaveType");
            Checker("#startDate","#errorstartDate");
            Checker("#returnDate","#errorreturnDate");
            Checker("#totalWorkDays","#errortotalWorkDays");
            if (isFalse > 0) {
                alert(alertmsg);
                isFalse = 0;
                return false;
            }
            isFalse = 0;
            return true;

        }

    </script>

    <?php
    if (isset($_POST['jobSummary']) && isset($_POST['project']) && isset($_POST['assignee'])) {
        if (!mysqli_query($conn,"INSERT INTO jobs (
                    project,
                    jobSummary,
                    fullDescription,
                    priority,
                    deadline,
                    estimatedMinutes,
                    accountExec,
                    jobstatus,
                    created
                    ) VALUES (
                    '".mysqli_real_escape_string($conn,$_POST['project'])."',
                    '".mysqli_real_escape_string($conn,$_POST['jobSummary'])."',
                    '".mysqli_real_escape_string($conn,$_POST['fullDescription'])."',
                    '".mysqli_real_escape_string($conn,$_POST['priority'])."',
                    '".mysqli_real_escape_string($conn,$_POST['deadline'])."',
                    '".mysqli_real_escape_string($conn,$_POST['estimatedMinutes'])."',
                    '".mysqli_real_escape_string($conn,$_POST['accountExec'])."',
                    '1',
                    NOW()
                    )"
        )) {
            echo '<span class="errormsg">Error creating job: '.mysqli_error($conn).'</span>';
        } else {

            $newjobNo = mysqli_insert_id($conn);



        foreach ($_POST['assignee'] as $assignee) {
            if (!mysqli_query($conn,"INSERT INTO relationalJobUsers (
                    jobNo,
                    userId
                    ) VALUES (
                    '".$newjobNo."',
                    '".$assignee."'
                    )"
            )) {
                echo '<span class="errormsg">Error assigning job: '.mysqli_error($conn).'</span>';
            }

            $result = mysqli_query($conn,"select firstname,email from users where userId = '".$assignee."'");
            while ($row = mysqli_fetch_array($result) ) {
                $firstname = $row['firstname'];
                $email = $row['email'];
            }

                    //send to assignee
                    $to = $email;
                    $subject = 'There is a new Job assigned to you Job #'.$newjobNo;

                    $headers = "From: jobs@firetree.co.za\r\n";
                    $headers .= "Reply-To: jobs@firetree.co.za\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message = 'Hi '.$firstname.',<br/>
                        <br/>
                        There is a new assigned to you, Job #'.$newjobNo.'.<br/>
                        <br/><strong>'.$_POST['jobSummary'].'</strong><br/>
                        <br/>
                        <a href="http://jobs.firetree.co.za/jobs/job.php?jobNo='.$newjobNo.'">Click here to view the Job</a><br/>
                        <br/>
                        <a href="http://jobs.firetree.co.za">Jobs.FireTree.co.za</a>';
                    $message .= '</body></html>';
                    mail($to, $subject, $message, $headers);
        }









            ?>
            <script type="text/javascript">
                <!--
                window.location = "job.php?jobNo=<?php echo $newjobNo;?>";
                //-->
            </script>
        <?php
        }
    } ?>
    <?php if ($completed == false) { ?>
        <?php if ($_SESSION['manager'] = '1' || $_SESSION['accountexec'] = 1) { ?>
        <div>
            <form action="createjob.php" method="post" onsubmit="formatDate('#deadline');" enctype="multipart/form-data" ><!--onSubmit="return validateForm();"-->



                        <?php getTierOne(); ?>


                    <span id="wait_1" style="display: none;">
                    <img alt="Please Wait" src="<?php echo HTTP.'images/ajax-loader.gif';?>"/>
                    </span>
                    <span id="result_1" style="display: none;"></span>



                <div id="displayForm" style="display: none;">

                    <input type="hidden" name="dateFormat" value="yyyy-mm-dd">
                    <script type="text/javascript">
                        function isValidDate(dateString) {
                            var regEx = /^\d{4}-\d{2}-\d{2}$/;
                            return dateString.match(regEx) != null;
                        }
                        function formatDate(thisid){
                            if (!isValidDate(jQuery(thisid).val())) {
                                jQuery( thisid ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                            }
                        }
                    </script>

                    <div class="form-group">
                        <label>Select Lead Designer(s) *</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">Who is assigned to complete this job?</span>
                        <span class="small text-muted">Hold [cmd] & click to select multiple assignees.</span>
                        <select multiple="multiple" class="form-control" id="assignee" name="assignee[]">
                            <option value="">Select Assignee(s)</option>
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT userId, concat(firstname,' ',surname) as designer from users where designer='1' and status='1' order by firstname ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option value="'.$crow['userId'].'">'.$crow['designer'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Account Executive *</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">This is the person who will approve the job and/or report back to the client.</span>
                        <select class="form-control" id="accountExec" name="accountExec">
                            <option value="">Select Account Executive</option>
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT userId, concat(firstname,' ',surname) as ae from users where accountExec='1' and status='1' order by firstname ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option value="'.$crow['userId'].'">'.$crow['ae'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deadline</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input onChange="formatDate('#deadline');" placeholder="Deadline" class="form-control" name="deadline" id="deadline">
                    </div>
                    <div class="form-group">
                        <label>Priority *</label>
                        <br/>
                        <select class="form-control" id="priority" name="priority">
                            <option value="">Select Priority</option>
                            <?php
                            $clientsresult = mysqli_query($conn,"SELECT priorityName, priorityId from priorities order by priorityId ASC");
                            while ($crow = mysqli_fetch_array($clientsresult) ) {
                                echo '<option value="'.$crow['priorityId'].'">'.$crow['priorityName'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estimated Completion Time in Minutes</label>
                        <br/><span class="errmsg" id="errestimatedMinutes"></span>
                        <input placeholder="Estimated Time in Minutes" class="form-control" name="estimatedMinutes" id="estimatedMinutes">
                    </div>
                    <div class="form-group">
                        <label>Job Summary</label>
                        <!--<br/><span class="small text-muted1" style="margin-bottom:5px;">Specify a descriptive name for your project. For example, "October 2014 Specials".</span>-->
                        <input placeholder="Job Summary" class="form-control" name="jobSummary" id="jobSummary">
                    </div>
                    <div class="form-group">
                        <label>Detailed Job Description</label>
                        <br/><span class="small text-muted1" style="margin-bottom:5px;">Enter as much info as possible</span>
                        <textarea contenteditable="true"  class="form-control" id="fullDescription" name="fullDescription" style="overflow:scroll; max-height:300px;"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-block" href="#" type="submit">Create Job</button>
                    </div>
                </div>
            </form>
        </div>
        <?php } else { ?>
        <div>
            You do not have permissions to create a new Job.<br/>Please ask an AE or a Manager to create the job bag for you.
        </div>
        <?php } ?>
    <?php } ?>



    </div>
    <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
<?php } ?>
<?php include '../pagebottom.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#fullDescription').summernote();
    });
</script>