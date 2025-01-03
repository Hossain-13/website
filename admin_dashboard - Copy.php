<?php
session_start();
$section = $_GET['section'] ?? 'users';
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
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <nav>
            <div class="nav_logo">
                <h1><a href="index.php">Hangout Planner</a></h1>
            </div>
            <ul class="nav_link">
                <li><a href="#" onclick="document.getElementById('section_form_users').submit();">Users</a></li>
                <li><a href="#" onclick="document.getElementById('section_form_plans').submit();">Hangout Plans</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="admin_section">
            <div class="admin_box">
                <h1><?php echo ucfirst($section); ?> List</h1>
                <form id="section_form_users" action="admin.php" method="post">
                    <input type="hidden" name="section" value="users">
                </form>
                <form id="section_form_plans" action="admin.php" method="post">
                    <input type="hidden" name="section" value="hangout plans">
                </form>
                <table class="admin_table">
                    <thead>
                        <?php
                        if (isset($_SESSION['admin_dashboard_results']) && !empty($_SESSION['admin_dashboard_results'])) {
                            $results = $_SESSION['admin_dashboard_results'];
                            if ($section == 'users') {
                                echo "<p>Here are the users:</p>";
                                echo "<tr>
                                        <th>Email</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Phone Number</th>
                                        <th>Date of Birth</th>
                                        <th>Sex</th>
                                        <th>Action</th>
                                      </tr>";
                            } else if ($section == 'hangout plans') {
                                echo "<p>Here are the hangout plans:</p>";
                                echo "<tr>
                                        <th>Hangout ID</th>
                                        <th>Hangout Creator</th>
                                      </tr>";
                            }
                        }
                        ?>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['admin_dashboard_results']) && !empty($_SESSION['admin_dashboard_results'])) {
                            $results = $_SESSION['admin_dashboard_results'];
                            foreach ($results as $row) {
                                if ($section == 'users') {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["f_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["m_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["l_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["phone_no"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["DOB"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["Sex"]) . "</td>";
                                    echo "<td style='background-color:rgba(255, 255, 255, 0.2);'>";
                                    echo "<a style='text-decoration:none;' href='modify_user.php?id=" . htmlspecialchars($row['Email']) . "'>";
                                    echo "<img src='img/update.png' alt='update' width='20' height='20'/>";
                                    echo "</a>";
                                    echo "<a style='text-decoration:none;' href='delete_user.php?id=" . htmlspecialchars($row['Email']) . "' onclick='return confirm(\"Confirm deletion?\");'>";
                                    echo "<img src='img/delete.png' alt='delete' width='20' height='20'/>";
                                    echo "</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                } else if ($section == 'hangout plans') {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["H_ID"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["REmail"]) . "</td>";
                                    echo "<td style='background-color:rgba(255, 255, 255, 0.2);'>";
                                    echo "<a style='text-decoration:none;' href='modify_plan.php?id=" . htmlspecialchars($row['H_ID']) . "'>";
                                    echo "<img src='img/update.png' alt='update' width='20' height='20'/>";
                                    echo "</a>";
                                    echo "<a style='text-decoration:none;' href='delete_plan.php?id=" . htmlspecialchars($row['H_ID']) . "' onclick='return confirm(\"Confirm deletion?\");'>";
                                    echo "<img src='img/delete.png' alt='delete' width='20' height='20'/>";
                                    echo "</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            unset($_SESSION['admin_dashboard_results']);
                        }
                        ?>
                    </tbody>
                </table>
                <a href="<?php echo $section == 'users' ? 'add_user.php' : 'add_plan.php'; ?>" class="btn">Add <?php echo ucfirst($section); ?></a>
            </div>
        </section>
    </main>
</body>
</html>