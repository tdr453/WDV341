<?php 
session_start();

if (!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== true) {
    header("Location: login.php");
    exit;
}

require_once('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administrator</title>
</head>

<body>
    <?php
        if (isset($_GET['message'])) {
            echo "<h1>" . htmlspecialchars($_GET['message']) . "</h1>";
        }
    ?>
    <h1>Hooray! You're logged in, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <ul>
        <li><a href="addEvent.php">Add New Event</a></li>
        <li><a href="listEvents.php">Show Events (Update/Delete)</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>

</html>