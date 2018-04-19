<?php
session_start();
include('conn.php');
session_destroy();
header('location:index.php?loggedout=true');
?>