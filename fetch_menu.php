<?php
require_once 'DBconnect.php';

if (isset($_POST['restaurant'])) {
    $restaurant = $_POST['restaurant'];
    $sql = "SELECT m.ITEM_NAME, m.Cuisine, m.Quantity, m.Price from restaurants r, menu m WHERE r.R_ID = m.R_ID AND r.R_NAME = '$restaurant'";
    $result = mysqli_query($conn,$sql);

    if ($result->num_rows > 0) {
        echo '<table class="restaurant_table">';
        echo "  <tr>
                <th>Item Name</th>
                <th>Cuisine</th>
                <th>Quantity</th>
                <th>Price</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "  <tr>
                    <td>" . htmlspecialchars($row['ITEM_NAME']) . "</td>
                    <td>" . htmlspecialchars($row['Cuisine']) . "</td>
                    <td>" . htmlspecialchars($row['Quantity']) . "</td>
                    <td>" . htmlspecialchars($row['Price']) . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo "No menu items available for this restaurant.";
    }

}
$conn->close();
?>

