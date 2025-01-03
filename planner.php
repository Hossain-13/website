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
    <script>
        function updateRestaurants() {
            const rBudget = document.getElementById('rBudget').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_restaurants.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('restaurant').innerHTML = this.responseText;
                }
            };
            xhr.send('rBudget=' + rBudget);
        }
        function updateActivity() {
            const aBudget = document.getElementById('aBudget').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_activity.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('activity').innerHTML = this.responseText;
                }
            };
            xhr.send('aBudget=' + aBudget);
        }
        function fetchMenu() {
            const restaurant = document.getElementById('restaurant').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_menu.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('menu').innerHTML = this.responseText;
                }
            };
            xhr.send('restaurant=' + restaurant);
        }
    </script>
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
        <section class="planner_section">
            <div class="planner_box">
                <h1>Plan Your Hangout</h1>
                <form action="summary.php" method="post" class="planner_form">
                    <div class="planner_part">
                        <label for="source">Source Location:</label>
                        <select name="source" id="source" required>
                            <option value="" disabled selected>Select your source location</option>
                            <?php
                            require_once 'DBconnect.php';
                            $sql = "SELECT L_NAME FROM location";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['L_NAME']) . "'>" . htmlspecialchars($row['L_NAME']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No locations available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="planner_part">
                        <label for="rBudget">Select Restaurant Budget:</label>
                        <div class="budget_labels">
                            <span>0tk</span>
                            <span id="rBudget_value">1000tk</span>
                            <span>1000tk</span>
                        </div>
                        <input type="range" name="rBudget" id="rBudget" min="0" max="1000" value="500" step="50" oninput="document.getElementById('rBudget_value').innerText = this.value + 'tk'; updateRestaurants();">
                    </div>
                    <div class="planner_part">
                        <label for="restaurant">Select Restaurant:</label>
                        <select name="restaurant" id="restaurant" required>
                            <option value="" disabled selected>Select a restaurant</option>
                        </select>
                        <button type="button" class="see_menu_btn" onclick="fetchMenu()">See Menu</button>
                    </div>
                    <div id="menu"></div>
                    <div class="planner_part">
                        <label for="aBudget">Select Activity Budget:</label>
                        <div class="budget_labels">
                            <span>0tk</span>
                            <span id="aBudget_value">1000tk</span>
                            <span>1000tk</span>
                        </div>
                        <input type="range" name="aBudget" id="aBudget" min="0" max="1000" value="500" step="50" oninput="document.getElementById('aBudget_value').innerText = this.value + 'tk'; updateActivity();">
                    </div>
                    <div class="planner_part">
                    <label for="activity">Select activity:</label>
                        <select name="activity" id="activity" required>
                            <option value="" disabled selected>Select a activity</option>
                        </select>
                    </div>
                    <div class="planner_part">
                        <label for="transport">Select Transport:</label>
                        <select name="transport" id="transport" required>
                            <option value="" disabled selected>Select a transport</option>
                            <?php
                            require_once 'DBconnect.php';
                            $sql = "SELECT T_NAME FROM transport";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['T_NAME']) . "'>" . htmlspecialchars($row['T_NAME']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No transports available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="planner_part">
                        <label for="people">Select Number of People:</label>
                        <input type="number" name="people" id="people" min="1" max="20" required>
                    </div>
                    <div class="submit_container">
                        <input type="submit" value="Submit" class="submit_btn">
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>