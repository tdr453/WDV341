<?php
    require_once __DIR__ . '/../ConnectionFiles/XAMPPDbConnect.php';  // Note: when migrating to Heartland change the connection file!
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
            // Prepare SQL query to select all events from the database
            $sql = "SELECT events_name, events_description, events_date
                    From wdv341_events";
            $stmt = $pdo->prepare($sql);
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
Create an SQL SELECT command in PDO that uses Prepared Statements to pull all the events from your events table.
Process the SQL command and create a result.  It will include error handling in case your SELECT fails to run properly or the table is empty.
Use a PHP loop to process each row in the result.
Format each row from the result into a table like row. You can build an HTML table, or use CSS Flexbox or CSS Grid layouts to make it look like a table.
Display the final results in the browser.
-->