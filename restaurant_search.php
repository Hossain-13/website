<?php
session_start();
require_once('DBconnect.php');

if ($conn->connect_error){
    die("Connection Failed: ".$conn->connect_error);
}   

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $search = $_POST["search_keyword"];
    $sql1= "SELECT * from restaurants WHERE R_NAME LIKE '%$search%'" ;
    $result1 = mysqli_query($conn,$sql1);
    $sql2 = "SELECT m.ITEM_NAME, r.R_NAME, r.L_NAME, m.Cuisine, m.Quantity, m.Price from restaurants r, menu m WHERE r.R_ID = m.R_ID AND ITEM_NAME LIKE '%$search%'" ;
    $result2 = mysqli_query($conn,$sql2);
    
    $results = [];

    if ($result1->num_rows > 0) {
        while ($row1 = mysqli_fetch_assoc($result1)){
            $results[] = [
                "type" => "restaurant",
                "R_NAME" => $row1["R_NAME"],
                "FoodPanda_Link" => $row1["FoodPanda_Link"],
                "R_GoogleMap_Link" => $row1["R_GoogleMap_Link"],
                "R_PHONE" => $row1["R_PHONE"],
                "R_WEBSITE" => $row1["R_WEBSITE"],
                "L_NAME" => $row1["L_NAME"]
            ];
        }
    } else if ($result2->num_rows > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $results[] = [
                "type" => "menu",
                "ITEM_NAME" => $row2["ITEM_NAME"],
                "R_NAME" => $row2["R_NAME"],
                "L_NAME" => $row2["L_NAME"],
                "Cuisine" => $row2["Cuisine"],
                "Quantity" => $row2["Quantity"],
                "Price" => $row2["Price"]
            ];
        }
    }

    $_SESSION['search_results'] = $results;
    header("Location: search.php");
    exit();
}
$conn->close();
?>