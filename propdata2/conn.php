<?php
$conn=mysqli_connect("localhost","root","","jobsfsvyxb_db1");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}