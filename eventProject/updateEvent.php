<?php
session_start();
require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';

// Protect this page
if (!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== true) {
    header("Location: login.php");
    exit;
}

// Validate and sanitize ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listEvents.php?message=Invalid event ID");
    exit;
}

$id = (int) $_GET['id'];

// --- CSRF Token Setup ---
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}
$form_token = $_SESSION['form_token'];

try {
    // Fetch event data
    $sql = "SELECT events_id, events_name, events_date, events_description 
            FROM wdv341_events 
            WHERE events_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        header("Location: listEvents.php?message=Event not found");
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CSRF check
        if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
            die("Invalid form submission.");
        }

        // Honeypot check
        if (!empty($_POST['honeypot'])) {
            die("Bot detected.");
        }

        // Collect updated values
        $name = trim($_POST['events_name']);
        $date = trim($_POST['events_date']);
        $description = trim($_POST['events_description']);

        // Update query
        $update_sql = "UPDATE wdv341_events 
                       SET events_name = :name, events_date = :date, events_description = :description 
                       WHERE events_id = :id";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $update_stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $update_stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $update_stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            header("Location: listEvents.php?message=Event updated successfully");
            exit;
        } else {
            $error_message = "Error updating event.";
        }
    }
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Event</title>
</head>
<body>
    <h1>Update Event</h1>
    <p><a href="listEvents.php">Back to Events</a> | <a href="logout.php">Logout</a></p>

    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <!-- CSRF Token -->
        <input type="hidden" name="form_token" value="<?php echo htmlspecialchars($form_token); ?>">
        <!-- Honeypot -->
        <input type="text" name="honeypot" style="display:none">

        <label for="events_name">Event Name:</label><br>
        <input type="text" id="events_name" name="events_name" 
               value="<?php echo htmlspecialchars($event['events_name']); ?>" required><br><br>

        <label for="events_date">Event Date:</label><br>
        <input type="date" id="events_date" name="events_date" 
               value="<?php echo htmlspecialchars($event['events_date']); ?>" required><br><br>

        <label for="events_description">Description:</label><br>
        <textarea id="events_description" name="events_description" rows="4" cols="50"><?php 
            echo htmlspecialchars($event['events_description']); ?></textarea><br><br>

        <input type="submit" value="Update Event">
    </form>
</body>
</html>