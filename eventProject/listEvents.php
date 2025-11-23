<?php
session_start();
require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';

// Protect this page: only valid users can see it
if (!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== true) {
    header("Location: login.php");
    exit;
}

// Query events table
try {
    $sql = "SELECT events_id, events_name, events_date, events_description 
            FROM wdv341_events 
            ORDER BY events_date ASC";
    $stmt = $pdo->query($sql);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error retrieving events: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event List</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Event List</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <p><a href="addEvent.php">Add New Event</a> | <a href="logout.php">Logout</a></p>

    <?php if ($events): ?>

        <?php
            if (isset($_GET['message'])) {
                echo "<p style='color: green; font-weight: bold;'>" . htmlspecialchars($_GET['message']) . "</p>";
            }
            ?>
            
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo $event['events_id']; ?></td>
                    <td><?php echo htmlspecialchars($event['events_name']); ?></td>
                    <td><?php echo htmlspecialchars($event['events_date']); ?></td>
                    <td><?php echo htmlspecialchars($event['events_description']); ?></td>
                    <td>
                        <a href="updateEvent.php?id=<?php echo $event['events_id']; ?>">Update</a> |
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $event['events_id']; ?>)">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <script>
            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this event?")) {
                    window.location.href = "delete-event.php?id=" + id;
                }
            }
            </script>

            </tbody>
        </table>
    <?php else: ?>
        <p>No events found.</p>
    <?php endif; ?>
</body>
</html>