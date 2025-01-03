<?php
session_start();
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
                <h1>Restaurants</h1>
                <form action="restaurant_search.php" method="post">
                    <div class="bar_btn">
                        <input type="text" name="search_keyword" class="search_bar" placeholder="Think of restaurants, food items, etc.">
                        <input type="submit" value="Search" class="search_btn">
                    </div>
                </form>
                <table class="restaurant_table">
                    <thead>
                        <?php
                        if (isset($_SESSION['search_results'])) {
                            $results = $_SESSION['search_results'];
                            if (!empty($results)) {
                                if ($results[0]['type'] == 'restaurant') {
                                    echo "<p>Great news! Found some restaurants for you:</p>";
                                    echo "<tr>
                                            <th>Restaurant Name</th>
                                            <th>Foodpanda Link</th>
                                            <th>Maps Link</th>
                                            <th>Phone No.</th>
                                            <th>Website/Fb Link</th>
                                            <th>Location</th>
                                          </tr>";
                                } else if ($results[0]['type'] == 'menu') {
                                    echo "<p>Excellent! Found some delicious items for you:</p>";
                                    echo "<tr>
                                            <th>Item</th>
                                            <th>Restaurant Name</th>
                                            <th>Location</th>
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
                                if ($result['type'] == 'restaurant') {
                                    if ($result["FoodPanda_Link"] == NULL) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($result["R_NAME"]) . "</td>";
                                        echo "<td><p>Coming Soon!</p></td>";
                                        echo "<td><a href='" . htmlspecialchars($result["R_GoogleMap_Link"]) . "'>Link</a></td>";
                                        echo "<td>" . htmlspecialchars($result["R_PHONE"]) . "</td>";
                                        echo "<td><a href='" . htmlspecialchars($result["R_WEBSITE"]) . "'>Link</a></td>";
                                        echo "<td>" . htmlspecialchars($result["L_NAME"]) . "</td>";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($result["R_NAME"]) . "</td>";
                                        echo "<td><a href='" . htmlspecialchars($result["FoodPanda_Link"]) . "'>Link</a></td>";
                                        echo "<td><a href='" . htmlspecialchars($result["R_GoogleMap_Link"]) . "'>Link</a></td>";
                                        echo "<td>" . htmlspecialchars($result["R_PHONE"]) . "</td>";
                                        echo "<td><a href='" . htmlspecialchars($result["R_WEBSITE"]) . "'>Link</a></td>";
                                        echo "<td>" . htmlspecialchars($result["L_NAME"]) . "</td>";
                                        echo "</tr>";
                                    }

                                } else if ($result['type'] == 'menu') {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($result["ITEM_NAME"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($result["R_NAME"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($result["L_NAME"]) . "</td>";
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
                <br>
                <button type="button" class="see_menu_btn" onclick="window.location.href='home.php'">Return Home</button>
            </div>
        </section>
    </main>
</body>
</html>