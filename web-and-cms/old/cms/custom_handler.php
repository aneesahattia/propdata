<?php
include('connect.php');

if(isset( $_GET['handles']))
{
	$funciton = $_GET['handles'];

	call_user_func($funciton);

}

function save_special_offer(){
	include('class.upload.php');
	$foo = new Upload($_FILES['so_image']); 
if ($foo->uploaded) {
	
	$foo->Process('../cms/images');
   if ($foo->processed) {
     echo 'original image copied';
   } else {
     echo 'error : ' . $foo->error;
   }
  }

}

function cleanInput($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
    return $output;
  }
?>
<?php
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}
