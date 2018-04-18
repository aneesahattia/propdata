<?php
 	include('connect.php');
 	$so_id = $_GET['so_id'];

 	$sql = "select * from special_offers where so_id='$so_id'";

 	$fetch = $dbh->query($sql);

 	while ($row=$fetch->fetch(PDO::FETCH_ASSOC)) {
 			$so_title = $row['so_title'];
 			$so_desc = $row['so_desc'];
 			$image   = $row['so_image_src'];

	}

if(isset($_GET['submit'])){

	$so_title = $_GET['so_title'];
	$so_desc = $_GET['so_desc'];
	$so_status = $_GET['so_status'];
	 	$so_id = $_GET['so_id'];


$target_dir = "images/";
$target_dir_2 = "images/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


$uploadOk = 1;
// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

       if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";

        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_dir_2. $_FILES['fileToUpload']['name']);
        
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }




$so_datetime = date("Y-m-d h:i:sa");

$dbh = $dbh->prepare("UPDATE `special_offers` SET `so_title` = '$so_title',
`so_desc` ='$so_desc' , `so_image_src`='$target_file',`so_status`='$so_status' WHERE `so_id` ='$so_id'
	");

print "UPDATE `special_offers` SET `so_title` = '$so_title',
`so_desc` ='$so_desc' , `so_image_src`='$target_file',`so_status`='$so_status' WHERE `so_id` ='$so_id'
	 ";

// $dbh->bindParam(':so_title', $so_title);
// $dbh->bindParam(':so_desc', $so_desc);

$dbh->execute();

  // print "
  //            <script type='text/javascript'>
  //                   alert('saved');
  //             </script>
  //       ";

  // print "<meta http-equiv='refresh' content='1;url=http://hettravel.co.za/cms/add_new.php'>"; 



}

 	


?>

	<form method="get" action="edit.php">
			Give a title :<input type="text" name="so_title" value="<?php print $so_title ?>"><p>
			Give a descripiton :<textarea name="so_desc"><?php print $so_desc ?></textarea><p>
			Image you are currently posting :<p><img src="<?php print $image ?>" width='300' height='313'><p>
		    Select a new image to upload:
		    <input type="file" name="fileToUpload" id="fileToUpload"><p>
		    Please select visibility <select name="so_status">
		    	<option value="1" >Active</option>	
		    			    	<option value="2" >Inactive</option>	

		    </select>
		    <input type="hidden" name="so_id" value="<? print $so_id?>">

		    <input type="submit" value="Update" name="submit">
	</form>
