<?php
require_once 'DBconnect.php';

if (isset($_POST['aBudget'])) {

    $activity = $_POST['aBudget'];
    $sql = "SELECT A_NAME from activity where A_PRICE between 0 and $activity ORDER BY A_NAME";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            echo "<option value='" . htmlspecialchars($row['A_NAME']) . "'>" . htmlspecialchars($row['A_NAME']) . "</option>";
        }
    } else {
        echo "<option value='' disabled>No restaurants available within budget</option>";
    }           
        }

$conn->close();
?>