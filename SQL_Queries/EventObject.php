<?php
require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';

// Tell the browser this is JSON
header('Content-Type: application/json');

try {
    // Hardcode an event ID for testing
    // Note: future use could add an if/while statement that looped through all of the results
    $eventID = 2;

    // Prepare SQL query using WHERE clause to limit the result set to one
    $sql = "SELECT events_id, events_name, events_description, events_presenter, events_date, events_time
            FROM wdv341_events
            WHERE events_id = :eventID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':eventID', $eventID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch one row as associative array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Define Event class
        class Event {
            public $events_id;
            public $events_name;
            public $events_description;
            public $events_presenter;
            public $events_date;
            public $events_time;

            // Class Constructor
            public function __construct($data) {
                $this->events_id = $data['events_id'];
                $this->events_name = $data['events_name'];
                $this->events_description = $data['events_description'];
                $this->events_presenter = $data['events_presenter'];
                $this->events_date = $data['events_date'];
                $this->events_time = $data['events_time'];
            }
        }

        // Create PHP object from row
        $outputObj = new Event($row);

        // Encode to JSON, JSON_PRETTY_PRINT makes the output easier to read
        echo json_encode($outputObj, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["error" => "No event found."]);
    }

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}