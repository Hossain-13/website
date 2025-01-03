<?php
session_start();
require_once('DBconnect.php');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$section = $_POST['section'] ?? 'users';

if ($section == 'users') {
    $sql1 = "SELECT * FROM user WHERE email NOT IN ('nakshatra.roy@gmail.com', 'jayed@gmail.com', 'hossain@gmail.com')";
    $result1 = mysqli_query($conn, $sql1);
} else if ($section == 'hangout plans') {
    $sql2 = "SELECT * FROM hangout_plans";
    $result2 = mysqli_query($conn, $sql2);
}

$results = [];

if ($result1 && mysqli_num_rows($result1) > 0) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $results[] = [
            "Email" => $row1["Email"],
            "f_name" => $row1["F_Name"],
            "m_name" => $row1["M_Name"],
            "l_name" => $row1["L_Name"],
            "phone_no" => $row1["Phone_No"],
            "DOB" => $row1["DOB"],
            "Sex" => $row1["Sex"]
        ];
    }
} else if ($result2 && mysqli_num_rows($result2) > 0) {
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $results[] = [
            "H_ID" => $row2["H_ID"],
            "REmail" => $row2["REmail"]
        ];
    }
}

$_SESSION['admin_dashboard_results'] = $results;
header("Location: admin_dashboard.php?section=$section");
exit();
?>