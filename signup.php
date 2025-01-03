<?php
require_once('DBconnect.php');

if (isset($_POST['email']) && isset($_POST['new_password']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone_number']) && isset($_POST['date_of_birth']) && isset($_POST['sex'])) {

    $username = $_POST['email'];
    $password = $_POST['new_password'];
    $f_name = $_POST['first_name'];
    $m_name = $_POST['middle_name'];
    $l_name = $_POST['last_name'];
    $phone_no = $_POST['phone_number'];
    $DOB = $_POST['date_of_birth'];
    $sex = $_POST['sex'];

    $sql1 = "SELECT * FROM user WHERE email = '$username'";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        echo "Account already exists. Please sign in.";
    } else {

        if ($m_name == "") {
            $sql2 = "INSERT INTO user VALUES ('$username', '$f_name', NULL, '$l_name', '$phone_no', '$password', '$DOB', '$sex')";    
        } else {
            $sql2 = "INSERT INTO user VALUES ('$username', '$f_name', '$m_name', '$l_name', '$phone_no', '$password', '$DOB', '$sex')";
        }
        
        $result2 = mysqli_query($conn, $sql2);
        $sql3 = "INSERT INTO regular_user VALUES ('$username')";
        $result3 = mysqli_query($conn, $sql3);
        $sql4 = "INSERT INTO manages VALUES ('nakshatra.roy@gmail.com', '$username'),('jayed@gmail.com', '$username'),('hossain@gmail.com', '$username')";
        $result4 = mysqli_query($conn, $sql4);
        header("Location: index.php");
    }
    
} else {
    echo "Please enter required fields.";
}
?>