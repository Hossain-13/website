<?php
session_start();
ob_start();
require_once('DBconnect.php');
ob_end_clean();


if(isset($_POST['email']) && isset($_POST['password'])){
    $username = $_POST['email'];
    $password = $_POST['password'];
    $sql1 = "SELECT * FROM regular_user R, user U WHERE R.REmail = U.Email AND R.REmail = '$username' AND U.password = '$password'";
    $result1 = mysqli_query($conn, $sql1);
    $sql2 = "SELECT * FROM admin A, user U WHERE A.AEmail = U.Email AND AEmail = '$username' AND U.password = '$password'";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result1) > 0){
        // echo "Let him enter";
        $_SESSION["user"] = $username;
        header("Location: home.php");
    }
    else if (mysqli_num_rows($result2) > 0){
        // echo "Let him enter";
        header("Location: admin_dashboard.php");
    }

    else{
        echo "Wrong email or password.";
    }
}
?>