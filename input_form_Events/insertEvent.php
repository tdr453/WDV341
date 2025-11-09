<?php
require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php'; // Note: when migrating to Heartland change the connection file!


// Collect form data
// Note: $_POST must match event the form input names
$eventName = $_POST['event_name'];
$eventDescription = $_POST['event_description'];
$eventPresenter = $_POST['event_presenter'];
$eventDate = $_POST['event_date'];
$eventTime = $_POST['event_time'];

// Current timestamps for insert/update
$dateInserted = date("Y-m-d");
$dateUpdated = date("Y-m-d");

try {
    $sql = "INSERT INTO wdv341_events
            (events_name, events_description, events_presenter, events_date, events_time, events_date_inserted, events_date_updated)
            VALUES (:eventName, :eventDescription, :eventPresenter, :eventDate, :eventTime, :dateInserted, :dateUpdated)";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':eventName', $eventName);
    $stmt->bindParam(':eventDescription', $eventDescription);
    $stmt->bindParam(':eventPresenter', $eventPresenter);
    $stmt->bindParam(':eventDate', $eventDate);
    $stmt->bindParam(':eventTime', $eventTime);
    $stmt->bindParam(':dateInserted', $dateInserted);
    $stmt->bindParam(':dateUpdated', $dateUpdated);
    
    $stmt->execute();
    
    echo "<h2>Event Successfully Added!</h2>";
    echo "<p><strong>Name:</strong> $eventName</p>";
    echo "<p><strong>Description:</strong> $eventDescription</p>";
    echo "<p><strong>Presenter:</strong> $eventPresenter</p>";
    echo "<p><strong>Date:</strong> $eventDate</p>";
    echo "<p><strong>Time:</strong> $eventTime</p>";
    
} catch(PDOException $e) {
    echo "Error inserting event: " . $e->getMessage();
}
?>