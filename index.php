<!DOCTYPE html>
<html>
<head>
    <title>PHP Login System</title>
</head>
<body>
    <h1>PHP Login System</h1>

    <?php
    session_start();

    // Check if the user is already authenticated
    if (isset($_SESSION['user_id'])) {
        echo "Welcome, " . $_SESSION['user_id'] . "!<br>";
        echo '<a href="logout.php">Logout</a>';
    } else {
        // Display the login form
        if (isset($_POST['login'])) {
            // Replace this with your actual user authentication logic
            $username = $_POST['username'];
            $password = $_POST['password'];

            // For demonstration purposes, we are using a hard-coded user
            $validUser = ($username === 'demo' && $password === 'password');

            if ($validUser) {
                $_SESSION['user_id'] = $username;
                echo "Login successful. Welcome, " . $_SESSION['user_id'] . "!<br>";
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo "Invalid username or password. Please try again.<br>";
            }
        }
    }
    ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="login" value="Login">
    </form>

    <br>

    <!-- SSO Login Button (Sample) -->
    <a href="sso-login.php">Login with SSO</a>
</body>
</html>
