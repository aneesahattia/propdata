<?php
include('connect.php');
include('custom_handler.php');

$so_title =  $_POST['so_title'];
$so_desc =  $_POST['so_desc'];


// print_r($_POST);

$target_dir = "../images/";
$target_dir_2 = "cms/images/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


$uploadOk = 1;
// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
       if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";

        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_dir_2. $_FILES['fileToUpload']['name']);
        
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}



$so_datetime = date("Y-m-d h:i:sa");

$dbh = $dbh->prepare("insert into special_offers(
	so_title,
	so_desc,	
	so_image_src,
    so_status,
    so_datetime
	)VALUES(
	:so_title,
	:so_desc,
	'$target_file',
    '1',
    '$so_datetime'
	)");

$dbh->bindParam(':so_title', $so_title);
$dbh->bindParam(':so_desc', $so_desc);

$dbh->execute();

  print "
             <script type='text/javascript'>
                    alert('saved');
              </script>
        ";

  print "<meta http-equiv='refresh' content='1;url=http://localhost/old/cms/add_new.php'>"; 



?>

