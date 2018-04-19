<?php
define('ROOT', __DIR__.'/');
define('HTTP', 'http://localhost/propdata2');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<?php
include ROOT .'/header.php';
?>
<body>
<?php if (isset($_SESSION['userId'])) { ?>
<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo HTTP;?>index.php"><strong>J</strong>obs<strong>.</strong><strong>F</strong>ire<strong>T</strong>ree</a>
</div>
<!-- /.navbar-header -->
<?php include ROOT.'navbar-toplinks.php'; ?>
<?php include ROOT.'navbar-sidelinks.php'; ?>
</nav>
<?php } ?>