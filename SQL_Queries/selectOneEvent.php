<?php
    require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';
    echo "<p style='color:green; font-weight:bold;'>Connected to XAMPPDbConnect</p>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!--HTML table to display data-->
    <!--<tr> holds table headers-->
    <table border=1>
        <tr>
            <th>Events Name</th>
            <th>Event Description</th>
            <th>Event Date</th>
        </tr>
        <?php
        try {
            //Hardcode an event using the unique events_id (primary key) for testing
            $eventID = 2;

            // Prepare SQL query with "where" clause to select one event
            // Bind teh PHP $eventID to the where SQL placeholder :eventID
            $sql = "SELECT events_name, events_description, events_date
                    From wdv341_events
                    Where events_id = :eventID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindvalue(':eventID', $eventID, PDO::PARAM_INT);
            $stmt->execute();

            // Check if any rows were returned
            if ($stmt->rowCount() > 0) {
                // Loop through each row in the table and echo it
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>" . $row["events_name"] . "</td>
                        <td>" . $row["events_description"] . "</td>
                        <td>" . $row["events_date"] . "</td>
                        </tr>";
                }
            } else {
                // If no events are found
                echo "<tr><td colspan='3' >No events found.</td></tr>";
            }
        } catch (PDOException $e) {
            // Display error message if query fails
            echo "<p style='color:red; font-weight:bold;'>Database error: " . $e->getMessage() . "</p>";
        }
        ?>
    </table>
    
</body>
</html>

<!--
Connect the page to your database using the dbConnect file.
Create an SQL SELECT command in PDO using Prepared Statements to pull one event from your event table.
Use the WHERE clause to access a single event from the table. For testing purposes hard code your event number into the variable. 
Process the SQL command and create a result.  It will include error handling in case your SELECT fails to run properly or the table is empty.
Use a PHP loop to process the record/row in the result.
Format the row from the result into a table like format. You can use and HTML table or use CSS Flexbox or Grid to display a table like format.
Display the final results to the client.
-->