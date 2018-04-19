<?php session_destroy(); ?>
<?php session_start(); ?>
<?php
include('conn.php');
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if (isset($_POST['uemail'])) {
    if (isset($_POST['uemail'])) { $uusername = mysqli_real_escape_string($conn, $_POST['uemail']); }
    if (isset($_POST['upassword'])) { $upassword = mysqli_real_escape_string($conn, $_POST['upassword']); }

    $result = mysqli_query($conn,"SELECT u.* FROM users u WHERE u.email='".$uusername."' and u.password=md5('".$upassword."') AND u.status = 1");
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if ($count > 0) {
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['surname'] = $row['surname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['designation'] = $row['designation'];
        $_SESSION['cell'] = $row['cell'];
        $_SESSION['designer'] = $row['designer'];
        $_SESSION['manager'] = $row['manager'];
        $_SESSION['accountexec'] = $row['accountexec'];
        $_SESSION['status'] = $row['status'];
        if ($row['profilePicture'] == "") {
            $_SESSION['profilePicture'] = 'defaultprofilepicture.png';
        } else {
            $_SESSION['profilePicture'] = $row['profilePicture'];
        }

        mysqli_query($conn,"UPDATE users SET loggedin = NOW() WHERE userId='".$_SESSION['userId']."'");
        if ($_POST['sessionUrl'] <> "") {
            header('location:'.$_POST['sessionUrl']);
        } else {
            header('location:index.php');
        }
    } else {
        header('location:index.php?error=login incorrect');
    }
} else {
    header('location:index.php');
}
?>