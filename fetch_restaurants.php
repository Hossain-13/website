<?php
require_once 'DBconnect.php';

if (isset($_POST['rBudget'])) {
    $budget = $_POST['rBudget'];
    $sql = "SELECT R_NAME FROM restaurants WHERE R_ID IN (SELECT R_ID FROM menu GROUP BY R_ID HAVING AVG(Price) <= $budget) ORDER BY R_NAME";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['R_NAME']) . "'>" . htmlspecialchars($row['R_NAME']) . "</option>";
        }
    } else {
        echo "<option value='' disabled>No restaurants available within budget</option>";
    }
}

$conn->close();
?>