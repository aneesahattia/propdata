<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $thistitle;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo HTTP;?>css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo HTTP;?>css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo HTTP;?>css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo HTTP;?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo HTTP;?>css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo HTTP;?>font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo HTTP;?>js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo HTTP;?>js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo HTTP;?>js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <!--<script src="js/plugins/morris/raphael.min.js"></script>-->
    <!--<script src="js/plugins/morris/morris.min.js"></script>-->
    <!--<script src="js/plugins/morris/morris-data.js"></script>-->
    <!-- DataTables JavaScript -->
    <script src="<?php echo HTTP;?>js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo HTTP;?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo HTTP;?>js/sb-admin-2.js"></script>

    <!-- include summernote css/js-->
    <link href="<?php echo HTTP;?>css/summernote.css" rel="stylesheet">
    <script src="<?php echo HTTP;?>js/summernote.min.js"></script>

</head>
<?php
include ROOT.'/conn.php'; ?>
<?php
if (!isset($_SESSION['userId'])) {
    //not logged in
} else {
    $userId = $_SESSION['userId'];
}
?>

<?php
$limit =20;
if (isset($_GET['p'])) {
    $p = $_GET['p'] == "" ? 1:$_GET['p'];
} else {
    $p = 1;
}
$counter = (($p * $limit)+1) - $limit;

$start = ($p-1) * $limit;
$limits= "LIMIT ".$start.",".$limit;
?>