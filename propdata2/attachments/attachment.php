<div id="uploader">

    <!-- status message will be appear here -->
    <div class="status"></div>

    <!-- multiple file upload form -->
    <form action="<?php echo HTTP;?>attachments/upload.php" method="post" enctype="multipart/form-data" class="pure-form">
        <input type="file" name="files[]" multiple="multiple" id="files">
        <input type="hidden" name="attacher" value="<?php echo $_SESSION['userId'];?>">
        <input type="hidden" name="attachmentJobNo" value="<?php echo $jobNo;?>">
        <input type="submit" value="Upload" class="pure-button pure-button-primary">
    </form>

</div><!-- end .container -->
<script type="text/javascript" src="<?php echo HTTP;?>js/jquery.form.min.js"></script>

<!-- main script -->
<script type="text/javascript" src="<?php echo HTTP;?>js/uploadscript.js"></script>
