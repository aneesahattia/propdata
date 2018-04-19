<div id="commenter">
<script type="text/javascript">
    $(document).ready(function() {
        $("#timelogged").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errtimelogged").html("Enter number(s) only.").show().fadeOut(2000);
                return false;
            }
        });
    });

    function formValidate() {
        if (jQuery('#timelogged').val() == "") {
            alert('Please enter your time in minutes');
            return false;
        }
        if (jQuery('#timetask').val() == "") {
            alert('Please select a task');
            return false;
        }
        return true;
    }
</script>
    <!-- status message will be appear here -->
    <div class="status"></div>

    <!-- multiple file upload form -->
    <form action="<?php echo HTTP;?>timesheets/upload.php" method="post" enctype="multipart/form-data" class="pure-form" onSubmit="return formValidate();">
        <div class="form-group">
            <br/><span class="errmsg" id="errtimelogged"></span>
            <input placeholder="Enter your time (In Minutes)" class="form-control" name="timelogged" id="timelogged">
        </div>
        <select name="timetask" id="timetask" data-placeholder="Select Task">
            <option value="">Select Task</option>
            <?php
                $result = mysqli_query($conn,"SELECT taskCategoryName, taskCategoryId from taskCategories order by taskCategoryId");
                while ($row = mysqli_fetch_array($result) ) {
                    echo '<optgroup label="'.$row['taskCategoryName'].'">';
                        $result2 = mysqli_query($conn,"SELECT taskName, taskId from tasks where taskCategory = '".$row['taskCategoryId']."' order by taskId");
                        while ($row2 = mysqli_fetch_array($result2) ) {
                            echo '<option value="'.$row2['taskId'].'">'.$row2['taskName'].'</option>';
                        }
                    echo '</optgroup>';
                }
            ?>
        </select><br/>
        <br/>
        <textarea name="timetaskComment" id="timetaskComment" placeholder="Enter Comments" rows="2" cols="40"></textarea><br/><br/>
        <input type="hidden" name="timesheetUserId" value="<?php echo $_SESSION['userId'];?>">
        <input type="hidden" name="timesheetJobNo" value="<?php echo $jobNo;?>">
        <input type="submit" value="Log Time" class="btn-success btn-sm btn">
    </form>

</div>