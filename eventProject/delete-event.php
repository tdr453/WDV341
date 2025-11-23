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

try {
    $sql = "DELETE FROM wdv341_events WHERE events_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if any row was deleted
    if ($stmt->rowCount() > 0) {
        header("Location: listEvents.php?message=Event deleted successfully");
    } else {
        header("Location: listEvents.php?message=Event not found or already deleted");
    }
} catch (PDOException $e) {
    header("Location: listEvents.php?message=Error deleting event");
}
exit;
?>