<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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
        <div class="planner_part">
            <table class="restaurant_table">
                <thead>
                    <?php
                    if (isset($_SESSION['search_results'])) {
                        $results = $_SESSION['search_results'];
                        if (!empty($results)) {
                            if ($results[0]['type'] == 'menu') {
                                echo "<tr>
                                        <th>Item</th>
                                        <th>Cuisine</th>
                                        <th>Serving Quantity</th>
                                        <th>Price</th>
                                    </tr>";
                            }
                        }
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['search_results'])) {
                        $results = $_SESSION['search_results'];
                        foreach ($results as $result) {
                            if ($result['type'] == 'menu') {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($result["ITEM_NAME"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["Cuisine"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["Quantity"]) . "</td>";
                                echo "<td>" . htmlspecialchars($result["Price"]) . "</td>";
                                echo "</tr>";
                            }
                        }
                        unset($_SESSION['search_results']);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>