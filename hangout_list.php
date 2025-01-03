<?php
session_start();
ob_start();
require_once('DBconnect.php');
ob_end_clean();

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$user = $_SESSION["user"];

$sql = "SELECT h.H_ID, r.R_NAME, a.A_NAME, t.T_NAME, h.P_NO, h.TOTAL 
        FROM hangout_plans h
        JOIN can_have c1 ON h.H_ID = c1.H_ID
        JOIN consists_of c2 ON h.H_ID = c2.H_ID
        JOIN may_have m ON h.H_ID = m.H_ID
        JOIN restaurants r ON r.R_ID = c1.R_ID
        JOIN activity a ON a.A_ID = c2.A_ID
        JOIN transport t ON t.T_NAME = m.T_NAME
        WHERE h.Creator = '$user'
        ORDER BY h.H_ID";
$result = mysqli_query($conn, $sql);

$results = [];

if ($result && $result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = [
            "H_ID" => $row["H_ID"],
            "R_NAME" => $row["R_NAME"],
            "A_NAME" => $row["A_NAME"],
            "T_NAME" => $row["T_NAME"],
            "P_NO" => $row["P_NO"],
            "TOTAL" => $row["TOTAL"],
        ];
    }
} else {
    $message = "You haven't created any hangout plans yet!";
}

$_SESSION['hangout_results'] = $results;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <title>Hangout Planner</title>
</head>
<body>
    <header>
        <nav>
            <div class="nav_logo">
                <h1><a href="index.php">Hangout Planner</a></h1>
            </div>
        </nav>
    </header>
    <main>
        <section class="restaurants">
            <div class="restaurant_box">
                <h1>Your Hangout Plans</h1>
                <?php if (!empty($message)): ?>
                    <p><?php echo htmlspecialchars($message); ?></p>
                <?php else: ?>
                <table class="restaurant_table">
                    <thead>
                        <?php
                        if (!empty($results)) {
                            echo "<tr>
                                    <th>Hangout ID</th>
                                    <th>Restaurant</th>
                                    <th>Activity</th>
                                    <th>Transport</th>
                                    <th>No. of people</th>
                                    <th>Total Cost(BDT)</th>
                                  </tr>";
                        }
                        ?>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($results)) {
                            foreach ($results as $result) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($result["H_ID"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["R_NAME"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["A_NAME"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["T_NAME"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["P_NO"]) . "</td>";
                                echo "<td>" . (int)($result["TOTAL"]) . "</td>";
                                echo "<td style='background-color:rgba(255, 255, 255, 0.2);'>";
                                echo "<a style='text-decoration:none; margin-left: 0px;' href='delete_hangout.php?id=" . htmlspecialchars($result["H_ID"]) . "' onclick='return confirm(\"Confirm deletion?\");'>";
                                echo "<img src='img/delete.png' alt='delete' width='18' height='18'/>";
                                echo "</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php endif; ?>
                <br>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="see_menu_btn" onclick="window.location.href='home.php'">Return Home</button>
                    <button type="button" class="see_menu_btn" onclick="window.location.href='planner.php'">Make another Plan!</button>
                </div>
            </div>
        </section>
    </main>
</body>
</html>