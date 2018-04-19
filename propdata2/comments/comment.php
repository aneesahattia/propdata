<div id="commenter">

    <!-- status message will be appear here -->
    <div class="status"></div>

    <!-- multiple file upload form -->
    <form action="<?php echo HTTP;?>comments/commentupload.php" method="post" enctype="multipart/form-data" class="pure-form">
        <textarea contenteditable="true"  class="form-control" id="comment" name="comment" style="overflow:scroll; max-height:300px;"></textarea>
        <input type="hidden" name="commenter" value="<?php echo $_SESSION['userId'];?>">
        <input type="hidden" name="commentJobNo" value="<?php echo $jobNo;?>">
        <input type="submit" value="Submit Comment" class="btn-success btn-xs btn">
    </form>

</div><!-- end .container -->
<script type="text/javascript" src="<?php echo HTTP;?>js/jquery.form.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#comment').summernote();
    });
</script>