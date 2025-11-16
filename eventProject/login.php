<?php
session_start();
require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';
require_once('functions.php');

$error_message = "";

// If form submitted, validate
if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (log_in($username, $password)) {
        $_SESSION['validUser'] = true;
        $_SESSION['username'] = $username;
    } else {
        $_SESSION['validUser'] = false;
        $error_message = "Invalid username or password. Please try again.";
    }
}

$isLoggedIn = isset($_SESSION['validUser']) && $_SESSION['validUser'] == true;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administrator Login</title>
</head>
<body>
    <h1>Administrator Page</h1>

    <?php if (isset($_SESSION['validUser']) && $_SESSION['validUser'] == true): ?>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <ul>
            <li><a href="addEvent.php">Add New Event</a></li>
            <li><a href="listEvents.php">Show Events (Update/Delete)</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    <?php else: ?>
        <?php if ($error_message): ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <p>
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" required>
            </p>
            <p>
                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required>
            </p>
            <input type="submit" name="submit" value="Login">
        </form>
    <?php endif; ?>
</body>
</html>