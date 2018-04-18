<?php
		include('class.upload.php');
?>
<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HET TRAVEL AND TOURS </title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="row" style="background-color:#fff">
<div class="col-lg-12 text-center logoheader">
<img src="img/logo.jpg">
</div>
</div>
<br>
<br>
 <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

<form action="upload.php" method="post" enctype="multipart/form-data">
<fieldset>
                                <div class="form-group">
<input class="form-control" placeholder="Provide a Title" name="so_title" type="text" autofocus>
                                </div>
<textarea cols="5" class="form-control" placeholder="Provide a Description" name="so_desc" type="text" autofocus>
</textarea>
<div class="checkbox">
                                    <label>
Select image to upload:
</label>
                                </div>
<div class="form-group">
<input type="file" name="fileToUpload" id="fileToUpload">
</div>
<input type="submit" name="submit" value="Upload" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<footer class="footer text-center">
      <div class="container">
        <p >Admin Login</p>
      </div>
    </footer>
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>

<!--

	Give a title :<input type="text" name="so_title"><p>
	Give a descripiton :<p>
	<textarea name="so_desc" row='20' col='20'></textarea><p>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
-->