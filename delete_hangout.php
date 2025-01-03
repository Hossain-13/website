<?php
session_start();
require_once('DBconnect.php');

if (isset($_GET['id'])) {
    $hangout_id = $_GET['id'];
    
    $sql5 = "DELETE FROM MODERATES WHERE H_ID = '$hangout_id'";
    $res5 = mysqli_query($conn,$sql5);
    $sql4 = "DELETE FROM MAY_HAVE WHERE H_ID = '$hangout_id'";
    $res4 = mysqli_query($conn,$sql4);
    $sql3 = "DELETE FROM CONSISTS_OF WHERE H_ID = '$hangout_id'";
    $res3 = mysqli_query($conn,$sql3);
    $sql2 = "DELETE FROM CAN_HAVE WHERE H_ID = '$hangout_id'";
    $res2 = mysqli_query($conn,$sql2);
    $sql1 = "DELETE FROM hangout_plans WHERE H_ID = '$hangout_id'";
    $res1 = mysqli_query($conn,$sql1);
    
    if (!($res1 && $res2 && $res3 && $res4 && $res5)) {
        echo "Error deleting hangout plan: " . mysqli_error($conn);
    } else {
        echo "Hangout plan deleted successfully.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

} else {
    echo "No hangout ID provided.";
}

mysqli_close($conn);
?>