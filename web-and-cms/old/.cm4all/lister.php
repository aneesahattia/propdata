<?php

error_reporting(E_ERROR);

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."include/config.php");
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."include/mime_types_data.php");
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."include/mime_types.php");
require_once("include/utils.php");

function new_file($dir, $file) {
    return preg_replace("/\/$/", "", preg_replace("/\/$/", "", $dir) . "/" . preg_replace("/^\//", "", $file));
}

function getDefaultThumbnailName($basename) {
   return preg_replace("/\.bmp$/", ".png", $basename);
}

function createListing($baseDir, $path) {
    global $serviceId;
    echo "<DIR>";

    $parent = new_file($baseDir, $path);
    $dParent = new_file($serviceId, $path);

    if (is_dir($parent)) {
        if ($dh = opendir($parent)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == "." || $file == "..") {
                    continue;
                }

                $fileUTF8 = mb_convert_encoding($file, "UTF-8", "UTF-8, ISO-8859-15");
                $child = new_file($parent, $fileUTF8);
                if (strcmp($file, $fileUTF8) != 0) {
                    /* ensure UTF-8 filename encoding */
                    rename(new_file($parent, $file), $child);
                }
                $dChild = new_file($path, $fileUTF8);
                $type = is_dir($child) ? "DIR" : "CHILD";

                echo "<$type";
                echo " ID=\"" . htmlspecialchars($dChild) . "\"";
                echo " PATH=\"" . htmlspecialchars($dChild) . "\"";
                echo " PARENT_ID=\"" . htmlspecialchars($dParent) . "\"";
                preg_match ( '/[^\/]*$/', $dChild, $matches);
                echo " BASENAME=\"" . htmlspecialchars($matches[0]) . "\"";
                echo " TYPE=\"" . ($type == "DIR" ? "DIR" : "FILE") . "\"";
                echo " LASTMODIFIED=\"" . date("YmdHis" , filemtime($child)) . "\"";

                if ($type == "CHILD") {
                    $contentType = getContentType($child);
                    echo " PUBLIC_URL=\"" . htmlspecialchars("/.cm4all/iproc.php" . urlenc($dChild)) . "\"";
                    echo " CONTENT_LENGTH=\"" . filesize($child) . "\"";
                    echo " CONTENT_TYPE=\"" . $contentType . "\"";
                    if (preg_match("~^image/(jpeg|png|gif)~",$contentType) === 1) {
                        echo " THUMBNAIL_URL=\"" .
                        htmlspecialchars("/.cm4all/iproc.php" . urlenc($dChild) . "/center_80_80_FFFFFF_80_80/" . getDefaultThumbnailName(urlenc(basename($dChild))))
                        . "\"";
                        $image_size =  getimagesize($child);
                        echo " WIDTH=\"".$image_size[0]."\" HEIGHT=\"".$image_size[1]."\"";
                    }else if (strpos($contentType, "video/") === 0 || $contentType == "application/x-shockwave-flash"){
                        echo " THUMBNAIL_URL=\"" .
                        htmlspecialchars("/.cm4all/vproc.php" . urlenc($dChild)) . "\"";
			$image_size =  getimagesize($child);
			echo " WIDTH=\"".$image_size[0]."\" HEIGHT=\"".$image_size[1]."\"";
                    }else{
                        echo " THUMBNAIL_URL=\"/.cm4all/widgetres.php/cm4all.com.widgets.VFS/res/file.png\"";
                    }
                }

                echo "/>";
            }
            closedir($dh);
        }
    }
    echo "</DIR>";
}

header("content-type: text/xml encoding=\"UTF-8\"");

$data = explode("/", $_SERVER["PATH_INFO"]);
array_shift($data);
$key = array_shift($data);
$serviceId = array_shift($data);
$path = "/" . implode("/", $data);

if (!isset($config["listingkey"]) || $config["listingkey"] == ""
|| $key != $config["listingkey"] || strpos($path, "..") !== FALSE
|| $serviceId != 0){
    header("HTTP/1.1 401 Authorization Required");
    echo "<ERROR>401 Authorization Required</ERROR>";
    exit;
}

$mediadb = (strpos($config["mediadb"], "/") != 0 ? "../" : "") . $config["mediadb"];

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
createListing($mediadb, $path);

?>