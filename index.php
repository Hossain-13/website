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
        <section class="auth">
            <div class="auth_box">
                <div id="login_form" class="form">
                    <h1>Login</h1>
                    <!--login.php is backend-->
                    <form action="login.php" method="post">
                        <input type="email" id="email" name="email" placeholder="Email" required>
                        <input type="password" id="password" name="password" placeholder="Password" minlength="6" required>
                        <div class="submit_container">
                            <input type="submit" value="Submit" class="submit_btn">
                        </div>
                    </form>
                    <div class="submit_container">
                        <p class="ext_text">Don't have an account? <a onclick="showSignup()" class="toggle_link">Sign Up</a></p>
                    </div>
                </div>
                <div id="signup_form" class="form" style="display: none;">
                    <h1>Sign Up</h1>
                    <!--signup.php is backend-->
                    <form action="signup.php" method="post" class="signup_flex">
                        <div class="signup_part">
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                            <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name">
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                            <input type="date" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="signup_part">
                            <select name="sex" id="sex" required>
                                <option value="" disabled selected>Sex</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                            <input type="tel" id="phone" name="phone_number" placeholder="Phone Number" pattern="0[0-9]{10}" required>
                            <input type="email" id="email" name="email" placeholder="Email" required>
                            <input type="password" id="new_password" name="new_password" placeholder="Password" minlength="6" required>
                        </div>
                        <div class="submit_container">
                            <input type="submit" value="Submit" class="submit_btn">
                        </div>
                    </form>
                    <div class="submit_container">
                        <p class="ext_text">Already have an account? <a onclick="showLogin()" class="toggle_link">Login</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        function showLogin() {
            document.getElementById('login_form').style.display = 'block';
            document.getElementById('signup_form').style.display = 'none';
        }

        function showSignup() {
            document.getElementById('login_form').style.display = 'none';
            document.getElementById('signup_form').style.display = 'block';
        }
    </script>
</body>
</html>